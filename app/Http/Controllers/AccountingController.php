<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\FinancialPeriod;
use App\Models\JournalEntry;
use App\Models\Invoice;
use App\Services\AccountingService;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    protected $accountingService;

    public function __construct(AccountingService $accountingService)
    {
        $this->accountingService = $accountingService;
    }

    // Dashboard
    public function dashboard()
    {
        $currentPeriod = FinancialPeriod::open()->first();
        $trialBalance = $this->accountingService->getTrialBalance($currentPeriod?->id);
        $incomeStatement = $this->accountingService->getIncomeStatement($currentPeriod?->id);
        $balanceSheet = $this->accountingService->getBalanceSheet($currentPeriod?->id);

        return view('accounting.dashboard', compact(
            'currentPeriod',
            'trialBalance',
            'incomeStatement',
            'balanceSheet'
        ));
    }

    // Chart of Accounts
    public function accounts()
    {
        $accounts = ChartOfAccount::with('parent', 'children')
            ->where('is_active', true)
            ->orderBy('account_code')
            ->get();

        return view('accounting.accounts', compact('accounts'));
    }

    public function createAccount()
    {
        $parentAccounts = ChartOfAccount::where('is_active', true)->get();
        return view('accounting.accounts.create', compact('parentAccounts'));
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'account_code' => 'required|string|unique:chart_of_accounts,account_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
            'parent_id' => 'nullable|exists:chart_of_accounts,id',
        ]);

        ChartOfAccount::create($validated);

        return redirect()->route('accounting.accounts')
            ->with('success', 'Account created successfully.');
    }

    // Financial Periods
    public function periods()
    {
        $periods = FinancialPeriod::with('closedBy')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('accounting.periods.index', compact('periods'));
    }

    public function createPeriod()
    {
        return view('accounting.periods.create');
    }

    public function storePeriod(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
        ]);

        FinancialPeriod::create($validated);

        return redirect()->route('accounting.periods')
            ->with('success', 'Financial period created successfully.');
    }

    public function closePeriod(FinancialPeriod $period)
    {
        if ($period->status !== 'open') {
            return back()->with('error', 'Period is already closed.');
        }

        $period->update([
            'status' => 'closed',
            'closed_by' => auth()->id(),
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Period closed successfully.');
    }

    // Journal Entries
    public function journalEntries()
    {
        $entries = JournalEntry::with(['financialPeriod', 'createdBy', 'lines.account'])
            ->orderBy('entry_date', 'desc')
            ->paginate(15);

        return view('accounting.journal', compact('entries'));
    }

    public function createJournalEntry()
    {
        $accounts = ChartOfAccount::where('is_active', true)->orderBy('account_code')->get();
        $periods = FinancialPeriod::open()->get();
        return view('accounting.journal.create', compact('accounts', 'periods'));
    }

    public function storeJournalEntry(Request $request)
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'description' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'financial_period_id' => 'required|exists:financial_periods,id',
            'lines' => 'required|array|min:2',
            'lines.*.account_id' => 'required|exists:accounts,id',
            'lines.*.entry_type' => 'required|in:debit,credit',
            'lines.*.amount' => 'required|numeric|min:0.01',
            'lines.*.description' => 'nullable|string',
        ]);

        $journalEntry = $this->accountingService->createJournalEntry($validated);

        return redirect()->route('accounting.journal.show', $journalEntry)
            ->with('success', 'Journal entry created successfully.');
    }

    public function showJournalEntry(JournalEntry $journalEntry)
    {
        $journalEntry->load(['financialPeriod', 'createdBy', 'lines.account', 'lines.student']);
        return view('accounting.journal.show', compact('journalEntry'));
    }

    public function postJournalEntry(JournalEntry $journalEntry)
    {
        try {
            $this->accountingService->postJournalEntry($journalEntry);
            return back()->with('success', 'Journal entry posted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editJournalEntry(JournalEntry $journalEntry)
    {
        $journalEntry->load(['financialPeriod', 'createdBy', 'lines.account']);
        $accounts = ChartOfAccount::where('is_active', true)->orderBy('account_code')->get();
        return view('accounting.journal.edit', compact('journalEntry', 'accounts'));
    }

    public function updateJournalEntry(Request $request, JournalEntry $journalEntry)
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'description' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'financial_period_id' => 'required|exists:financial_periods,id',
            'lines' => 'required|array|min:2',
            'lines.*.account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.entry_type' => 'required|in:debit,credit',
            'lines.*.amount' => 'required|numeric|min:0.01',
            'lines.*.description' => 'nullable|string',
        ]);

        $journalEntry->update($validated);

        // Update lines
        $journalEntry->lines()->delete();
        foreach ($validated['lines'] as $lineData) {
            $journalEntry->lines()->create([
                'account_id' => $lineData['account_id'],
                'debit' => $lineData['entry_type'] === 'debit' ? $lineData['amount'] : 0,
                'credit' => $lineData['entry_type'] === 'credit' ? $lineData['amount'] : 0,
                'description' => $lineData['description'],
            ]);
        }

        return redirect()->route('accounting.journal.show', $journalEntry)
            ->with('success', 'Journal entry updated successfully.');
    }

    public function reverseJournalEntry(JournalEntry $journalEntry)
    {
        try {
            $this->accountingService->reverseJournalEntry($journalEntry);
            return back()->with('success', 'Journal entry reversed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteJournalEntry(JournalEntry $journalEntry)
    {
        try {
            $journalEntry->lines()->delete();
            $journalEntry->delete();
            return back()->with('success', 'Journal entry deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Financial Reports
    public function trialBalance()
    {
        $periods = FinancialPeriod::orderBy('start_date', 'desc')->get();
        $currentPeriod = FinancialPeriod::open()->first();
        $trialBalance = $this->accountingService->getTrialBalance($currentPeriod?->id);

        return view('accounting.reports.trial-balance', compact(
            'periods',
            'currentPeriod',
            'trialBalance'
        ));
    }

    public function incomeStatement()
    {
        $periods = FinancialPeriod::orderBy('start_date', 'desc')->get();
        $currentPeriod = FinancialPeriod::open()->first();
        $incomeStatement = $this->accountingService->getIncomeStatement($currentPeriod?->id);

        return view('accounting.reports.income-statement', compact(
            'periods',
            'currentPeriod',
            'incomeStatement'
        ));
    }

    public function balanceSheet()
    {
        $periods = FinancialPeriod::orderBy('start_date', 'desc')->get();
        $currentPeriod = FinancialPeriod::open()->first();
        $balanceSheet = $this->accountingService->getBalanceSheet($currentPeriod?->id);

        return view('accounting.reports.balance-sheet', compact(
            'periods',
            'currentPeriod',
            'balanceSheet'
        ));
    }

    public function cashFlow()
    {
        $periods = FinancialPeriod::orderBy('start_date', 'desc')->get();
        $currentPeriod = FinancialPeriod::open()->first();
        
        // Simplified cash flow statement
        $trialBalance = $this->accountingService->getTrialBalance($currentPeriod?->id);
        
        $cashAccounts = collect($trialBalance['accounts'])->filter(function($account) {
            return in_array($account['account']->subtype, ['current_asset']) && 
                   str_contains(strtolower($account['account']->name), 'cash');
        });

        $operatingActivities = [];
        $investingActivities = [];
        $financingActivities = [];

        return view('accounting.reports.cash-flow', compact(
            'periods',
            'currentPeriod',
            'cashAccounts',
            'operatingActivities',
            'investingActivities',
            'financingActivities'
        ));
    }

    // Invoices
    public function invoices()
    {
        $invoices = Invoice::with(['invoiceable', 'items'])
            ->orderBy('invoice_date', 'desc')
            ->paginate(15);

        return view('accounting.invoices', compact('invoices'));
    }

    public function createInvoice()
    {
        $accounts = Account::active()->ofType('revenue')->orderBy('code')->get();
        return view('accounting.invoices.create', compact('accounts'));
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'invoiceable_type' => 'required|string',
            'invoiceable_id' => 'required|integer',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.account_id' => 'required|exists:accounts,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        // Calculate totals
        $subtotal = 0;
        foreach ($validated['items'] as &$item) {
            $item['line_total'] = $item['quantity'] * $item['unit_price'];
            $subtotal += $item['line_total'];
        }

        $validated['subtotal'] = $subtotal;
        $validated['tax_amount'] = 0; // TODO: Calculate tax based on rules
        $validated['total'] = $subtotal + $validated['tax_amount'];

        $invoice = $this->accountingService->createInvoice($validated);

        return redirect()->route('accounting.invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function showInvoice(Invoice $invoice)
    {
        $invoice->load(['invoiceable', 'items.account', 'createdBy']);
        return view('accounting.invoices.show', compact('invoice'));
    }

    public function postInvoice(Invoice $invoice)
    {
        try {
            $this->accountingService->postInvoice($invoice);
            return back()->with('success', 'Invoice posted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // General Ledger
    public function generalLedger()
    {
        $accounts = \App\Models\ChartOfAccount::orderBy('account_code')->get();
        
        // Get journal entry lines with their related data
        $journalEntryLines = \App\Models\JournalEntryLine::with(['journalEntry.financialPeriod', 'journalEntry.createdBy', 'account'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('accounting.general-ledger.index', compact('accounts', 'journalEntryLines'));
    }

    public function generalLedgerAccount(\App\Models\ChartOfAccount $account)
    {
        $journalEntries = \App\Models\JournalEntry::whereHas('lines', function($query) use ($account) {
                $query->where('account_id', $account->id);
            })
            ->with(['financialPeriod', 'createdBy', 'lines' => function($query) use ($account) {
                $query->where('account_id', $account->id);
            }])
            ->orderBy('entry_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        // Calculate balance from journal entry lines for this account
        $debitTotal = \App\Models\JournalEntryLine::where('account_id', $account->id)->sum('debit');
        $creditTotal = \App\Models\JournalEntryLine::where('account_id', $account->id)->sum('credit');
        $balance = $debitTotal - $creditTotal;
        
        return view('accounting.general-ledger.account', compact('account', 'journalEntries', 'balance'));
    }

    // Accounts Receivable
    public function accountsReceivable()
    {
        $customers = \App\Models\Student::with(['fees' => function($query) {
                $query->where('balance', '>', 0);
            }])
            ->whereHas('fees', function($query) {
                $query->where('balance', '>', 0);
            })
            ->orderBy('last_name')
            ->paginate(20);
        
        $totalReceivable = $customers->sum(function($customer) {
            return $customer->fees ? $customer->fees->sum('balance') : 0;
        });
        
        return view('accounting.accounts-receivable.index', compact('customers', 'totalReceivable'));
    }

    public function accountsReceivableAging()
    {
        $customers = \App\Models\Student::with(['fees' => function($query) {
                $query->where('balance', '>', 0);
            }])
            ->whereHas('fees', function($query) {
                $query->where('balance', '>', 0);
            })
            ->orderBy('last_name')
            ->get();
        
        $agingBuckets = [
            'current' => 0,
            '1-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            '90+' => 0,
        ];
        
        $customerAging = [];
        
        foreach ($customers as $customer) {
            $customerTotal = 0;
            $customerBuckets = [
                'current' => 0,
                '1-30' => 0,
                '31-60' => 0,
                '61-90' => 0,
                '90+' => 0,
            ];
            
            foreach ($customer->fees as $fee) {
                if ($fee->balance > 0) {
                    $daysOverdue = $fee->due_date ? now()->diffInDays($fee->due_date) : 0;
                    
                    if ($daysOverdue <= 0) {
                        $bucket = 'current';
                    } elseif ($daysOverdue <= 30) {
                        $bucket = '1-30';
                    } elseif ($daysOverdue <= 60) {
                        $bucket = '31-60';
                    } elseif ($daysOverdue <= 90) {
                        $bucket = '61-90';
                    } else {
                        $bucket = '90+';
                    }
                    
                    $customerBuckets[$bucket] += $fee->balance;
                    $customerTotal += $fee->balance;
                    $agingBuckets[$bucket] += $fee->balance;
                }
            }
            
            $customerAging[$customer->id] = [
                'customer' => $customer,
                'buckets' => $customerBuckets,
                'total' => $customerTotal
            ];
        }
        
        return view('accounting.accounts-receivable.aging', compact('customerAging', 'agingBuckets'));
    }

    public function accountsReceivableCustomer(\App\Models\Student $student)
    {
        $student->load(['fees.feeStructure', 'fees.feePayments']);
        
        return view('accounting.accounts-receivable.customer', compact('student'));
    }

    // Accounts Payable
    public function accountsPayable()
    {
        // For demo purposes, using expenses as payables
        $vendors = collect(); // Would be Vendor model in real implementation
        $expenses = \App\Models\JournalEntry::where('debit', '>', 0)
            ->where('description', 'like', '%expense%')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $totalPayable = $expenses->sum('debit');
        
        return view('accounting.accounts-payable.index', compact('vendors', 'expenses', 'totalPayable'));
    }

    public function accountsPayableAging()
    {
        $expenses = \App\Models\JournalEntry::where('debit', '>', 0)
            ->where('description', 'like', '%expense%')
            ->orderBy('date', 'desc')
            ->get();
        
        $agingBuckets = [
            'current' => 0,
            '1-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            '90+' => 0,
        ];
        
        foreach ($expenses as $expense) {
            $daysOverdue = now()->diffInDays($expense->date);
            
            if ($daysOverdue <= 0) {
                $bucket = 'current';
            } elseif ($daysOverdue <= 30) {
                $bucket = '1-30';
            } elseif ($daysOverdue <= 60) {
                $bucket = '31-60';
            } elseif ($daysOverdue <= 90) {
                $bucket = '61-90';
            } else {
                $bucket = '90+';
            }
            
            $agingBuckets[$bucket] += $expense->debit;
        }
        
        return view('accounting.accounts-payable.aging', compact('expenses', 'agingBuckets'));
    }

    public function accountsPayableVendor($vendorId)
    {
        // For demo purposes
        $expenses = \App\Models\JournalEntry::where('debit', '>', 0)
            ->where('description', 'like', '%expense%')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('accounting.accounts-payable.vendor', compact('vendorId', 'expenses'));
    }

    // Student Statements
    public function studentStatements()
    {
        $students = \App\Models\Student::with(['fees.feeStructure', 'fees.feePayments'])
            ->orderBy('last_name')
            ->paginate(20);
        
        return view('accounting.student-statements.index', compact('students'));
    }

    public function studentStatement(\App\Models\Student $student)
    {
        $student->load(['fees.feeStructure', 'fees.feePayments']);
        
        return view('accounting.student-statements.show', compact('student'));
    }

    public function studentStatementPdf(\App\Models\Student $student)
    {
        $student->load(['fees.feeStructure', 'fees.feePayments']);
        
        // Generate PDF (would use PDF library in real implementation)
        return response()->view('accounting.student-statements.pdf', compact('student'))
            ->header('Content-Type', 'application/pdf');
    }
    
    public function cashbook()
    {
        // Get today's transactions (placeholder data)
        $todayTransactions = collect([]);
        $cashBalance = 0;
        $bankBalance = 0;
        $todayReceipts = 0;
        $todayPayments = 0;
        
        return view('accounting.cashbook', compact(
            'todayTransactions',
            'cashBalance',
            'bankBalance',
            'todayReceipts',
            'todayPayments'
        ));
    }
}

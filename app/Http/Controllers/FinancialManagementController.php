<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Receipt;
use App\Models\PaymentMethod;
use App\Models\CashBook;
use App\Models\BankTransaction;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinancialManagementController extends Controller
{
    // Banks Management
    public function banks()
    {
        $banks = Bank::with('bankAccounts')->orderBy('bank_name')->paginate(15);
        return view('financial.banks.index', compact('banks'));
    }

    public function createBank()
    {
        return view('financial.banks.create');
    }

    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'bank_code' => 'required|string|unique:banks',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|in:checking,savings,business,investment',
            'branch_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        Bank::create($validated);
        return redirect()->route('financial.banks')->with('success', 'Bank created successfully.');
    }

    public function editBank(Bank $bank)
    {
        return view('financial.banks.edit', compact('bank'));
    }

    public function updateBank(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'bank_code' => 'required|string|unique:banks,bank_code,' . $bank->id,
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|in:checking,savings,business,investment',
            'branch_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $bank->update($validated);
        return redirect()->route('financial.banks')->with('success', 'Bank updated successfully.');
    }

    // Bank Accounts Management
    public function bankAccounts()
    {
        $bankAccounts = BankAccount::with('bank')->orderBy('account_name')->paginate(15);
        return view('financial.bank-accounts.index', compact('bankAccounts'));
    }

    public function createBankAccount()
    {
        $banks = Bank::where('is_active', true)->orderBy('bank_name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('sort_order')->get();
        return view('financial.bank-accounts.create', compact('banks', 'paymentMethods'));
    }

    public function storeBankAccount(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'account_name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_type' => 'required|in:checking,savings,business,investment,credit_card',
            'currency' => 'required|string|size:3',
            'overdraft_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        BankAccount::create($validated);
        return redirect()->route('financial.bank-accounts')->with('success', 'Bank account created successfully.');
    }

    // Cash Book Management
    public function cashBook()
    {
        $transactions = CashBook::with(['bankAccount', 'student', 'staff'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);
        
        $balance = CashBook::latest()->first()?->balance ?? 0;
        
        return view('financial.cash-book.index', compact('transactions', 'balance'));
    }

    public function createCashBookEntry()
    {
        $bankAccounts = BankAccount::with('bank')->where('is_active', true)->get();
        $students = \App\Models\Student::orderBy('first_name')->get();
        return view('financial.cash-book.create', compact('bankAccounts', 'students'));
    }

    public function storeCashBookEntry(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'category' => 'required|in:income,expense,transfer,adjustment',
            'debit_amount' => 'nullable|numeric|min:0',
            'credit_amount' => 'nullable|numeric|min:0',
            'transaction_type' => 'required|in:receipt,payment,transfer,adjustment',
            'reference' => 'nullable|string|max:255',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'student_id' => 'nullable|exists:students,id',
            'notes' => 'nullable|string',
        ]);

        $validated['balance'] = $validated['debit_amount'] - $validated['credit_amount'];
        $validated['transaction_number'] = 'CB-' . date('YmdHis');
        $validated['staff_id'] = auth()->id();

        CashBook::create($validated);
        return redirect()->route('financial.cash-book')->with('success', 'Cash book entry created successfully.');
    }

    // Receipts Management
    public function receipts()
    {
        $receipts = Receipt::with(['paymentMethod', 'bankAccount', 'student', 'staff'])
            ->orderBy('receipt_date', 'desc')
            ->paginate(20);
        
        return view('financial.receipts.index', compact('receipts'));
    }

    public function createReceipt()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('sort_order')->get();
        $bankAccounts = BankAccount::with('bank')->where('is_active', true)->get();
        $students = \App\Models\Student::orderBy('first_name')->get();
        $invoices = Invoice::where('status', '!=', 'paid')->orderBy('invoice_date', 'desc')->get();
        
        return view('financial.receipts.create', compact(
            'paymentMethods', 'bankAccounts', 'students', 'invoices'
        ));
    }

    public function storeReceipt(Request $request)
    {
        $validated = $request->validate([
            'receipt_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:tuition,fees,accommodation,meals,transport,supplies,other',
            'received_from' => 'nullable|string|max:255',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'student_id' => 'nullable|exists:students,id',
            'payment_status' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['receipt_number'] = 'R-' . date('YmdHis');
        $validated['created_by'] = auth()->id();

        Receipt::create($validated);
        return redirect()->route('financial.receipts')->with('success', 'Receipt created successfully.');
    }

    // Payment Methods Management
    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('financial.payment-methods.index', compact('paymentMethods'));
    }

    public function createPaymentMethod()
    {
        return view('financial.payment-methods.create');
    }

    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255',
            'method_type' => 'required|in:cash,bank_transfer,mobile_money,credit_card,debit_card,online_payment,check',
            'provider' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'supports_refunds' => 'boolean',
            'fees' => 'nullable|numeric|min:0',
            'daily_limit' => 'nullable|numeric|min:0',
            'monthly_limit' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
        ]);

        PaymentMethod::create($validated);
        return redirect()->route('financial.payment-methods')->with('success', 'Payment method created successfully.');
    }

    // Bank Reconciliation
    public function bankReconciliation()
    {
        $bankAccounts = BankAccount::with('bank')->where('is_active', true)->get();
        return view('financial.reconciliation.index', compact('bankAccounts'));
    }

    public function reconcileBank(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'reconciliation_date' => 'required|date',
            'ending_balance' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Get unreconciled transactions
        $unreconciledTransactions = BankTransaction::where('bank_account_id', $bankAccount->id)
            ->where('reconciled', false)
            ->orderBy('transaction_date')
            ->get();

        $reconciledBalance = $validated['ending_balance'];
        $runningBalance = $bankAccount->balance;

        foreach ($unreconciledTransactions as $transaction) {
            $transaction->reconciled = true;
            $transaction->reconciliation_date = $validated['reconciliation_date'];
            $transaction->balance_before = $runningBalance;
            $transaction->balance_after = $runningBalance + $transaction->amount;
            $transaction->save();
            
            $runningBalance = $transaction->balance_after;
        }

        // Update bank account balance
        $bankAccount->balance = $reconciledBalance;
        $bankAccount->save();

        return redirect()->route('financial.bank-accounts')->with('success', 'Bank account reconciled successfully.');
    }

    // Enhanced Invoice Management with Payment Integration
    public function enhancedInvoices()
    {
        $invoices = Invoice::with(['invoiceable', 'items', 'payments'])
            ->orderBy('invoice_date', 'desc')
            ->paginate(15);
        
        return view('financial.invoices.index', compact('invoices'));
    }

    public function processInvoicePayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($invoice->total - $invoice->amount_paid),
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['payment_number'] = 'P-' . date('YmdHis');
        $validated['invoice_id'] = $invoice->id;
        $validated['payable_type'] = get_class($invoice->invoiceable);
        $validated['payable_id'] = $invoice->invoiceable_id;
        $validated['received_by'] = auth()->id();

        $payment = Payment::create($validated);

        // Update invoice paid amount
        $invoice->amount_paid += $validated['amount'];
        if ($invoice->amount_paid >= $invoice->total) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partial';
        }
        $invoice->save();

        return redirect()->route('financial.invoices')->with('success', 'Payment processed successfully.');
    }

    // Financial Dashboard
    public function financialDashboard()
    {
        $totalCashInHand = CashBook::sum('credit_amount') - CashBook::sum('debit_amount');
        $totalBankBalance = BankAccount::sum('balance');
        $totalReceivables = Invoice::where('status', '!=', 'paid')->sum('total') - Invoice::where('status', '!=', 'paid')->sum('amount_paid');
        $totalPayables = Invoice::where('status', 'paid')->sum('total');
        
        $recentTransactions = BankTransaction::with('bankAccount')
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        $upcomingInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<=', now()->addDays(30))
            ->orderBy('due_date')
            ->get();

        return view('financial.dashboard', compact(
            'totalCashInHand',
            'totalBankBalance',
            'totalReceivables',
            'totalPayables',
            'recentTransactions',
            'upcomingInvoices'
        ));
    }

    // Bank Transaction Management
    public function storeBankTransaction(Request $request)
    {
        $validated = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'transaction_type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
        
        // Create bank transaction
        $transaction = BankTransaction::create([
            'bank_account_id' => $validated['bank_account_id'],
            'transaction_type' => $validated['transaction_type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date'],
            'reference_number' => $validated['reference_number'],
            'balance_before' => $bankAccount->current_balance,
            'created_by' => auth()->id(),
        ]);

        // Update bank account balance
        if ($validated['transaction_type'] === 'credit') {
            $bankAccount->current_balance += $validated['amount'];
        } else {
            $bankAccount->current_balance -= $validated['amount'];
        }
        $bankAccount->save();

        return redirect()->back()->with('success', 'Bank transaction added successfully.');
    }

    public function storeMultipleBankTransactions(Request $request)
    {
        $validated = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'transactions' => 'required|array|min:1',
            'transactions.*.date' => 'required|date',
            'transactions.*.type' => 'required|in:credit,debit',
            'transactions.*.amount' => 'required|numeric|min:0.01',
            'transactions.*.description' => 'required|string|max:255',
            'transactions.*.reference' => 'nullable|string|max:255',
        ]);

        $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
        $transactionsAdded = 0;

        foreach ($validated['transactions'] as $transactionData) {
            $transaction = BankTransaction::create([
                'bank_account_id' => $validated['bank_account_id'],
                'transaction_type' => $transactionData['type'],
                'amount' => $transactionData['amount'],
                'description' => $transactionData['description'],
                'transaction_date' => $transactionData['date'],
                'reference_number' => $transactionData['reference'],
                'balance_before' => $bankAccount->current_balance,
                'created_by' => auth()->id(),
            ]);

            // Update bank account balance
            if ($transactionData['type'] === 'credit') {
                $bankAccount->current_balance += $transactionData['amount'];
            } else {
                $bankAccount->current_balance -= $transactionData['amount'];
            }

            $transactionsAdded++;
        }

        $bankAccount->save();

        return redirect()->back()->with('success', "{$transactionsAdded} transactions added successfully.");
    }

    public function importBankTransactions(Request $request)
    {
        $validated = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $transactionsAdded = 0;
        $errors = [];

        if (($handle = fopen($path, 'r')) !== FALSE) {
            $header = fgetcsv($handle, 1000, ',');
            
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                try {
                    $transactionData = [
                        'date' => $data[0] ?? null,
                        'description' => $data[1] ?? '',
                        'amount' => $data[2] ?? 0,
                        'type' => $data[3] ?? 'credit',
                        'reference' => $data[4] ?? null,
                    ];

                    // Validate and process transaction
                    if ($transactionData['date'] && $transactionData['amount'] > 0) {
                        $transaction = BankTransaction::create([
                            'bank_account_id' => $validated['bank_account_id'],
                            'transaction_type' => $transactionData['type'],
                            'amount' => abs($transactionData['amount']),
                            'description' => $transactionData['description'],
                            'transaction_date' => $transactionData['date'],
                            'reference_number' => $transactionData['reference'],
                            'balance_before' => $bankAccount->current_balance,
                            'created_by' => auth()->id(),
                        ]);

                        // Update bank account balance
                        if ($transactionData['type'] === 'credit') {
                            $bankAccount->current_balance += abs($transactionData['amount']);
                        } else {
                            $bankAccount->current_balance -= abs($transactionData['amount']);
                        }

                        $transactionsAdded++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error processing row: " . $e->getMessage();
                }
            }
            
            fclose($handle);
        }

        $bankAccount->save();

        $message = "Import completed. {$transactionsAdded} transactions added.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " errors occurred.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function importBankStatement(Request $request)
    {
        $validated = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'statement_file' => 'required|file|mimes:csv,ofx,qfx',
        ]);

        $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
        $file = $request->file('statement_file');
        $extension = $file->getClientOriginalExtension();
        
        // For now, we'll handle CSV files (OFX/QFX would require additional parsing libraries)
        if ($extension === 'csv') {
            return $this->importBankTransactions($request);
        }

        return redirect()->back()->with('info', 'OFX/QFX import coming soon. Please use CSV format for now.');
    }
}

<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\FinancialPeriod;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Invoice;
use App\Models\FeePayment;
use Illuminate\Support\Facades\DB;

class AccountingService
{
    public function createJournalEntry(array $data): JournalEntry
    {
        return DB::transaction(function () use ($data) {
            $journalEntry = JournalEntry::create([
                'entry_number' => $data['entry_number'] ?? 'JE-' . strtoupper(uniqid()),
                'financial_period_id' => $data['financial_period_id'] ?? $this->getCurrentPeriod()->id,
                'entry_date' => $data['entry_date'] ?? now(),
                'description' => $data['description'],
                'reference' => $data['reference'] ?? null,
                'status' => 'draft',
                'created_by' => auth()->id() ?? 1, // Default to user 1 if not authenticated
            ]);

            foreach ($data['lines'] as $line) {
                JournalEntryLine::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $line['account_id'],
                    'debit' => $line['entry_type'] === 'debit' ? $line['amount'] : 0,
                    'credit' => $line['entry_type'] === 'credit' ? $line['amount'] : 0,
                    'description' => $line['description'] ?? null,
                ]);
            }

            return $journalEntry;
        });
    }

    public function postJournalEntry(JournalEntry $journalEntry): JournalEntry
    {
        $totalDebit = $journalEntry->lines->sum('debit');
        $totalCredit = $journalEntry->lines->sum('credit');

        if ($totalDebit !== $totalCredit) {
            throw new \Exception('Journal entry must balance (debits must equal credits)');
        }

        return DB::transaction(function () use ($journalEntry) {
            $journalEntry->update([
                'status' => 'posted',
                'approved_by' => auth()->id() ?? 1, // Default to user 1 if not authenticated
            ]);

            return $journalEntry;
        });
    }

    public function recordPayment(FeePayment $payment): void
    {
        DB::transaction(function () use ($payment) {
            // Get existing accounts for the journal entry
            $cashAccount = ChartOfAccount::where('type', 'asset')->where('name', 'like', '%Cash%')->first();
            $receivableAccount = ChartOfAccount::where('type', 'asset')->where('name', 'like', '%Receivable%')->first();
            
            if (!$cashAccount || !$receivableAccount) {
                throw new \Exception('Required accounts not found for payment recording');
            }

            // Create journal entry for the payment
            $journalData = [
                'description' => "Payment #{$payment->receipt_number}",
                'reference' => $payment->receipt_number,
                'lines' => [
                    // Debit: Cash/Bank Account
                    [
                        'account_id' => $cashAccount->id,
                        'entry_type' => 'debit',
                        'amount' => $payment->amount,
                        'description' => 'Cash/Bank - ' . $payment->receipt_number,
                    ],
                    // Credit: Accounts Receivable
                    [
                        'account_id' => $receivableAccount->id,
                        'entry_type' => 'credit',
                        'amount' => $payment->amount,
                        'description' => 'Accounts Receivable - ' . $payment->receipt_number,
                    ],
                ],
            ];

            $journalEntry = $this->createJournalEntry($journalData);
            $this->postJournalEntry($journalEntry);
        });
    }

    public function reverseJournalEntry(JournalEntry $journalEntry): void
    {
        DB::transaction(function () use ($journalEntry) {
            // Create reversing entry
            $reversingData = [
                'description' => "Reversal of: " . $journalEntry->description,
                'reference' => "REVERSAL-" . $journalEntry->entry_number,
                'financial_period_id' => $journalEntry->financial_period_id,
                'lines' => [],
            ];

            foreach ($journalEntry->lines as $line) {
                // Reverse the debit/credit
                $reversingData['lines'][] = [
                    'account_id' => $line->account_id,
                    'entry_type' => $line->debit > 0 ? 'credit' : 'debit', // Reverse the entry type
                    'amount' => $line->debit + $line->credit, // Use the original amount
                    'description' => "Reversal of: " . $line->description,
                ];
            }

            $reversingEntry = $this->createJournalEntry($reversingData);
            $this->postJournalEntry($reversingEntry);

            // Mark original entry as reversed
            $journalEntry->update(['status' => 'reversed']);
        });
    }

    public function getTrialBalance($financialPeriodId = null): array
    {
        $periodId = $financialPeriodId ?? $this->getCurrentPeriod()->id;
        
        $accounts = ChartOfAccount::with(['journalEntryLines' => function($query) use ($periodId) {
            $query->whereHas('journalEntry', function($q) use ($periodId) {
                $q->where('financial_period_id', $periodId)->where('status', 'posted');
            });
        }])->where('is_active', true)->get();

        $trialBalance = [];
        $totalDebits = 0;
        $totalCredits = 0;

        foreach ($accounts as $account) {
            $totalDebit = $account->journalEntryLines->sum('debit');
            $totalCredit = $account->journalEntryLines->sum('credit');
            
            $balance = $this->calculateAccountBalance($account, $totalDebit, $totalCredit);

            if ($balance != 0) {
                $normalBalance = $this->getNormalBalance($account->type);
                
                if (($normalBalance === 'debit' && $balance > 0) || 
                    ($normalBalance === 'credit' && $balance < 0)) {
                    $debitAmount = abs($balance);
                    $creditAmount = 0;
                } else {
                    $debitAmount = 0;
                    $creditAmount = abs($balance);
                }

                $trialBalance[] = [
                    'account' => $account,
                    'debit' => $debitAmount,
                    'credit' => $creditAmount,
                ];

                $totalDebits += $debitAmount;
                $totalCredits += $creditAmount;
            }
        }

        return [
            'accounts' => $trialBalance,
            'total_debits' => $totalDebits,
            'total_credits' => $totalCredits,
        ];
    }

    public function getIncomeStatement($financialPeriodId = null): array
    {
        $periodId = $financialPeriodId ?? $this->getCurrentPeriod()->id;
        $trialBalance = $this->getTrialBalance($periodId);

        $revenues = [];
        $expenses = [];
        $totalRevenue = 0;
        $totalExpense = 0;

        foreach ($trialBalance['accounts'] as $account) {
            $accountModel = $account['account'];
            
            if ($accountModel->type === 'revenue') {
                $revenues[] = $account;
                $totalRevenue += $account['credit'];
            } elseif ($accountModel->type === 'expense') {
                $expenses[] = $account;
                $totalExpense += $account['debit'];
            }
        }

        $netIncome = $totalRevenue - $totalExpense;

        return [
            'revenues' => $revenues,
            'total_revenue' => $totalRevenue,
            'expenses' => $expenses,
            'total_expense' => $totalExpense,
            'net_income' => $netIncome,
        ];
    }

    public function getBalanceSheet($financialPeriodId = null): array
    {
        $periodId = $financialPeriodId ?? $this->getCurrentPeriod()->id;
        $trialBalance = $this->getTrialBalance($periodId);
        $incomeStatement = $this->getIncomeStatement($periodId);

        $assets = [];
        $liabilities = [];
        $equity = [];
        $totalAssets = 0;
        $totalLiabilities = 0;
        $totalEquity = 0;

        foreach ($trialBalance['accounts'] as $account) {
            $accountModel = $account['account'];
            
            if ($accountModel->type === 'asset') {
                $assets[] = $account;
                $totalAssets += $account['debit'] - $account['credit'];
            } elseif ($accountModel->type === 'liability') {
                $liabilities[] = $account;
                $totalLiabilities += $account['credit'] - $account['debit'];
            } elseif ($accountModel->type === 'equity') {
                $equity[] = $account;
                $totalEquity += $account['credit'] - $account['debit'];
            }
        }

        // Add current period net income to equity
        $totalEquity += $incomeStatement['net_income'];

        return [
            'assets' => $assets,
            'total_assets' => $totalAssets,
            'liabilities' => $liabilities,
            'total_liabilities' => $totalLiabilities,
            'equity' => $equity,
            'total_equity' => $totalEquity,
        ];
    }

    private function calculateAccountBalance($account, $totalDebit, $totalCredit): float
    {
        $normalBalance = $this->getNormalBalance($account->type);
        
        if ($normalBalance === 'debit') {
            return $totalDebit - $totalCredit;
        } else {
            return $totalCredit - $totalDebit;
        }
    }

    private function getNormalBalance(string $accountType): string
    {
        return in_array($accountType, ['asset', 'expense']) ? 'debit' : 'credit';
    }

    private function getCurrentPeriod(): ?FinancialPeriod
    {
        return FinancialPeriod::open()->first();
    }

    private function getAccountIdByCode(string $code): ?int
    {
        return ChartOfAccount::where('account_code', $code)->first()?->id;
    }

    private function getCashAccountId(string $paymentMethod): int
    {
        $cashAccountCodes = [
            'cash' => '1000',
            'bank_transfer' => '1100',
            'mobile_money' => '1110',
            'check' => '1120',
        ];

        $code = $cashAccountCodes[$paymentMethod] ?? '1000';
        return $this->getAccountIdByCode($code);
    }
}

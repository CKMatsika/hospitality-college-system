<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Services\AccountingService;

Route::get('/test-accounting', function() {
    try {
        // Test 1: Check if we have chart of accounts
        $accountCount = \App\Models\ChartOfAccount::count();
        echo "Chart of accounts in database: {$accountCount}\n";
        
        // Test 2: Check if we have a financial period
        $period = \App\Models\FinancialPeriod::where('status', 'open')->first();
        echo "Financial period: " . ($period ? $period->name : 'None') . "\n";
        
        // Test 3: Create a test journal entry
        $accountingService = app(AccountingService::class);
        
        $journalData = [
            'description' => 'Test Journal Entry',
            'financial_period_id' => $period->id,
            'lines' => [
                [
                    'account_id' => \App\Models\ChartOfAccount::first()->id,
                    'entry_type' => 'debit',
                    'amount' => 100.00,
                    'description' => 'Test Debit',
                ],
                [
                    'account_id' => \App\Models\ChartOfAccount::skip(1)->first()->id,
                    'entry_type' => 'credit',
                    'amount' => 100.00,
                    'description' => 'Test Credit',
                ],
            ],
        ];
        
        $journalEntry = $accountingService->createJournalEntry($journalData);
        echo "Created journal entry: {$journalEntry->entry_number}\n";
        
        // Test 4: Post the journal entry
        $postedEntry = $accountingService->postJournalEntry($journalEntry);
        echo "Posted journal entry: {$postedEntry->status}\n";
        
        // Test 5: Generate trial balance
        $trialBalance = $accountingService->getTrialBalance($period->id);
        echo "Trial balance accounts: " . count($trialBalance['accounts']) . "\n";
        echo "Total debits: " . $trialBalance['total_debits'] . "\n";
        echo "Total credits: " . $trialBalance['total_credits'] . "\n";
        
        echo "✅ All accounting tests passed!\n";
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        echo "Line: " . $e->getLine() . "\n";
    }
});

Route::get('/test-workflow', function() {
    try {
        echo "🧪 Testing Complete Workflow: Payment → Registration → LMS → Accounting\n\n";
        
        // Test 1: Find a student with fees
        $studentFee = \App\Models\StudentFee::with('student', 'feeStructure')->first();
        if (!$studentFee) {
            echo "❌ No student fees found. Please create a student with fees first.\n";
            return;
        }
        
        echo "📝 Student: " . $studentFee->student->full_name ?? 'N/A' . "\n";
        echo "💰 Fee: " . $studentFee->feeStructure->name ?? 'N/A' . "\n";
        echo "💵 Amount: " . $studentFee->amount . "\n";
        echo "📊 Status: " . $studentFee->status . "\n\n";
        
        // Test 2: Record a payment
        $payment = \App\Models\FeePayment::create([
            'student_fee_id' => $studentFee->id,
            'student_id' => $studentFee->student_id,
            'amount' => min(100, $studentFee->amount), // Pay 100 or full amount
            'payment_method' => 'cash',
            'receipt_number' => 'TEST-' . strtoupper(uniqid()),
            'payment_date' => now(),
            'received_by' => 1, // Assuming user ID 1 exists
        ]);
        
        echo "💳 Payment recorded: " . $payment->receipt_number . "\n";
        echo "💵 Amount: " . $payment->amount . "\n\n";
        
        // Test 3: Update student fee status
        $totalPaid = $studentFee->feePayments()->sum('amount');
        $balance = max(0, $studentFee->amount - $totalPaid);
        
        $studentFee->update([
            'paid' => $totalPaid,
            'balance' => $balance,
            'status' => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending'),
        ]);
        
        echo "📊 Updated fee status: " . $studentFee->status . "\n";
        echo "💰 Total paid: " . $totalPaid . "\n";
        echo "💳 Balance: " . $balance . "\n\n";
        
        // Test 4: Update registration status
        $student = $studentFee->student;
        $previousStatus = $student->registration_status;
        
        app(\App\Services\StudentRegistrationService::class)->updateRegistrationStatus($student);
        
        echo "🎓 Registration status: " . $previousStatus . " → " . $student->registration_status . "\n";
        
        // Test 5: LMS auto-enrollment if registered
        if ($previousStatus !== 'registered' && $student->registration_status === 'registered') {
            app(\App\Services\StudentLmsAutoEnrollmentService::class)->autoEnrollForStudent($student);
            echo "📚 LMS auto-enrollment triggered!\n";
        }
        
        // Test 6: Create accounting journal entry
        try {
            app(\App\Services\AccountingService::class)->recordPayment($payment);
            echo "📊 Accounting journal entry created!\n";
        } catch (\Exception $e) {
            echo "❌ Accounting entry failed: " . $e->getMessage() . "\n";
        }
        
        // Test 7: Verify trial balance
        $trialBalance = app(\App\Services\AccountingService::class)->getTrialBalance();
        echo "📈 Trial balance: " . count($trialBalance['accounts']) . " accounts\n";
        echo "⚖️  Debits = Credits: " . ($trialBalance['total_debits'] == $trialBalance['total_credits'] ? '✅' : '❌') . "\n";
        
        echo "\n🎉 Complete workflow test finished!\n";
        
    } catch (\Exception $e) {
        echo "❌ Workflow test failed: " . $e->getMessage() . "\n";
        echo "📍 Line: " . $e->getLine() . " in " . $e->getFile() . "\n";
    }
});

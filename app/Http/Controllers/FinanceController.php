<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Services\StudentRegistrationService;
use App\Services\StudentLmsAutoEnrollmentService;
use App\Services\AccountingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_revenue' => FeePayment::sum('amount'),
            'pending_fees' => StudentFee::where('status', 'pending')->sum('amount'),
            'total_students' => Student::count(),
            'paid_this_month' => FeePayment::whereMonth('payment_date', now()->month)->sum('amount'),
            'male_students' => Student::where('gender', 'male')->count(),
            'female_students' => Student::where('gender', 'female')->count(),
        ];

        // Get students by program with gender breakdown
        $studentsByProgram = \App\Models\Program::withCount([
            'students as male_count' => function($query) {
                $query->where('gender', 'male');
            },
            'students as female_count' => function($query) {
                $query->where('gender', 'female');
            },
            'students as total'
        ])->get();

        $stats['students_by_program'] = $studentsByProgram;

        $recentPayments = FeePayment::with('studentFee.student')
            ->orderBy('payment_date', 'desc')
            ->take(10)
            ->get();

        return view('finance.dashboard', compact('stats', 'recentPayments'));
    }

    // Fee Structure Management
    public function feeStructures()
    {
        $feeStructures = FeeStructure::with('program')
            ->orderBy('name')
            ->paginate(10);
        
        return view('finance.fee-structures.index', compact('feeStructures'));
    }

    public function createFeeStructure()
    {
        $programs = Program::where('status', 'active')->get();
        return view('finance.fee-structures.create', compact('programs'));
    }

    public function storeFeeStructure(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:semester,annual,monthly',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        FeeStructure::create($validated);

        return redirect()->route('finance.fee-structures')
            ->with('success', 'Fee structure created successfully.');
    }

    public function editFeeStructure(FeeStructure $feeStructure)
    {
        $programs = Program::where('status', 'active')->get();
        return view('finance.fee-structures.edit', compact('feeStructure', 'programs'));
    }

    public function updateFeeStructure(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'program_id' => 'required|exists:programs,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:full,installment,semester',
            'status' => 'required|in:active,inactive',
        ]);

        $feeStructure->update($validated);

        return redirect()->route('finance.fee-structures')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroyFeeStructure(FeeStructure $feeStructure)
    {
        // Check if fee structure is being used by any student fees
        if ($feeStructure->studentFees()->count() > 0) {
            return redirect()->route('finance.fee-structures')
                ->with('error', 'Cannot delete fee structure that is assigned to students.');
        }

        $feeStructure->delete();

        return redirect()->route('finance.fee-structures')
            ->with('success', 'Fee structure deleted successfully.');
    }

    // Student Fees Management
    public function studentFees()
    {
        $studentFees = StudentFee::with(['student', 'feeStructure'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('finance.student-fees.index', compact('studentFees'));
    }

    public function createStudentFee()
    {
        $students = Student::where('status', 'active')->get();
        $feeStructures = FeeStructure::where('status', 'active')->get();
        return view('finance.student-fees.create', compact('students', 'feeStructures'));
    }

    public function storeStudentFee(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_structure_id' => 'required|exists:fee_structures,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'academic_term' => 'nullable|string|max:255',
        ]);

        $feeStructure = FeeStructure::find($validated['fee_structure_id']);
        
        StudentFee::create([
            'student_id' => $validated['student_id'],
            'fee_structure_id' => $validated['fee_structure_id'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'academic_term' => $validated['academic_term'],
            'status' => 'pending',
        ]);

        return redirect()->route('finance.student-fees')
            ->with('success', 'Student fee created successfully.');
    }

    // Payment Management
    public function payments()
    {
        $payments = FeePayment::with(['studentFee.student', 'studentFee.feeStructure'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10);
        
        return view('finance.payments.index', compact('payments'));
    }

    public function createPayment()
    {
        $studentFees = StudentFee::with(['student', 'feeStructure'])
            ->where('status', 'pending')
            ->get();
        
        $students = Student::where('status', 'active')->get();
        $feeStructures = FeeStructure::where('status', 'active')->get();
        
        return view('finance.payments.create', compact('studentFees', 'students', 'feeStructures'));
    }

    public function storePayment(Request $request)
    {
        $paymentType = $request->payment_type;
        
        if ($paymentType === 'invoice') {
            $validated = $request->validate([
                'student_fee_id' => 'required|exists:student_fees,id',
                'amount' => 'required|numeric|min:0|max:' . StudentFee::find($request->student_fee_id)->amount,
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,bank_transfer,mobile_money,check',
                'transaction_id' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);

            $studentFee = StudentFee::find($validated['student_fee_id']);

            $payment = FeePayment::create([
                'student_fee_id' => $studentFee->id,
                'student_id' => $studentFee->student_id,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['transaction_id'] ?? null,
                'receipt_number' => 'RCT-' . strtoupper(uniqid()),
                'notes' => $validated['notes'] ?? null,
                'payment_date' => $validated['payment_date'],
                'received_by' => auth()->id(),
            ]);

            // Update student fee paid/balance/status
            $totalPaid = (float) $studentFee->feePayments()->sum('amount');
            $due = (float) $studentFee->amount - (float) ($studentFee->discount ?? 0);
            $balance = max(0, $due - $totalPaid);

            $studentFee->forceFill([
                'paid' => $totalPaid,
                'balance' => $balance,
                'status' => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending'),
            ])->save();

            // Update registration state + auto-enroll LMS if registration completes
            $student = $studentFee->student;
            if ($student) {
                $previousStatus = $student->registration_status;

                app(StudentRegistrationService::class)->updateRegistrationStatus($student);

                if ($previousStatus !== 'registered' && $student->registration_status === 'registered') {
                    app(StudentLmsAutoEnrollmentService::class)->autoEnrollForStudent($student);
                }
            }

            // Create accounting journal entry for the payment
            try {
                app(AccountingService::class)->recordPayment($payment);
            } catch (\Exception $e) {
                // Log error but don't fail the payment
                \Log::error('Failed to create accounting journal entry: ' . $e->getMessage());
            }

            $message = 'Payment recorded successfully!';
            
        } else {
            // Advance Payment
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'fee_structure_id' => 'required|exists:fee_structures,id',
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,bank_transfer,mobile_money,check',
                'transaction_id' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);

            $student = Student::find($validated['student_id']);
            $feeStructure = FeeStructure::find($validated['fee_structure_id']);
            $academicTermId = $feeStructure?->academic_term_id;

            $studentFee = StudentFee::create([
                'student_id' => $student->id,
                'fee_structure_id' => $feeStructure->id,
                'academic_term_id' => $academicTermId,
                'amount' => $feeStructure->amount,
                'discount' => 0,
                'paid' => 0,
                'balance' => $feeStructure->amount,
                'status' => 'pending',
                'due_date' => null,
            ]);

            $payment = FeePayment::create([
                'student_fee_id' => $studentFee->id,
                'student_id' => $student->id,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['transaction_id'] ?? null,
                'receipt_number' => 'RCT-' . strtoupper(uniqid()),
                'notes' => trim(($validated['notes'] ?? '') . ' [ADVANCE PAYMENT]') ?: '[ADVANCE PAYMENT]',
                'payment_date' => $validated['payment_date'],
                'received_by' => auth()->id(),
            ]);

            $totalPaid = (float) $studentFee->feePayments()->sum('amount');
            $due = (float) $studentFee->amount - (float) ($studentFee->discount ?? 0);
            $balance = max(0, $due - $totalPaid);

            $studentFee->forceFill([
                'paid' => $totalPaid,
                'balance' => $balance,
                'status' => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending'),
            ])->save();

            $previousStatus = $student->registration_status;
            app(StudentRegistrationService::class)->updateRegistrationStatus($student);
            if ($previousStatus !== 'registered' && $student->registration_status === 'registered') {
                app(StudentLmsAutoEnrollmentService::class)->autoEnrollForStudent($student);
            }

            $message = 'Advance payment recorded successfully!';
        }

        // Generate receipt if requested
        if ($request->generate_receipt) {
            return redirect()->route('finance.payments.receipt', $payment->id)
                ->with('success', $message . ' Receipt generated.');
        }

        return redirect()->route('finance.payments.index')
            ->with('success', $message);
    }

    public function showPayment(FeePayment $payment)
    {
        $payment->load(['studentFee.student', 'studentFee.feeStructure']);
        return view('finance.payments.show', compact('payment'));
    }

    public function destroyPayment(FeePayment $payment)
    {
        // Check if payment can be deleted (business logic)
        if ($payment->payment_date->diffInDays(now()) > 30) {
            return redirect()->back()->with('error', 'Payments older than 30 days cannot be deleted.');
        }

        // Get student fee for balance recalculation
        $studentFee = $payment->studentFee;

        // Delete the payment
        $payment->delete();

        // Recalculate student fee balance
        if ($studentFee) {
            $totalPaid = $studentFee->feePayments()->sum('amount');
            $due = (float) $studentFee->amount - (float) ($studentFee->discount ?? 0);
            $balance = max(0, $due - $totalPaid);

            $studentFee->forceFill([
                'paid' => $totalPaid,
                'balance' => $balance,
                'status' => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending'),
            ])->save();

            // Update student registration status
            $student = $studentFee->student;
            if ($student) {
                app(StudentRegistrationService::class)->updateRegistrationStatus($student);
            }
        }

        return redirect()->route('finance.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function generateReceipt($id)
    {
        $payment = FeePayment::with(['studentFee.student', 'studentFee.feeStructure'])->findOrFail($id);
        
        return view('finance.payments.receipt', compact('payment'));
    }

    // Reports
    public function revenueReport()
    {
        $driver = DB::connection()->getDriverName();

        $monthlyRevenueSelect = $driver === 'sqlite'
            ? "CAST(strftime('%m', payment_date) AS INTEGER) as month, strftime('%Y', payment_date) as year, SUM(amount) as total"
            : 'MONTH(payment_date) as month, YEAR(payment_date) as year, SUM(amount) as total';

        $monthlyRevenue = FeePayment::selectRaw($monthlyRevenueSelect)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        $programRevenue = FeePayment::join('student_fees', 'fee_payments.student_fee_id', '=', 'student_fees.id')
            ->join('fee_structures', 'student_fees.fee_structure_id', '=', 'fee_structures.id')
            ->join('programs', 'fee_structures.program_id', '=', 'programs.id')
            ->selectRaw('programs.name, SUM(fee_payments.amount) as total')
            ->groupBy('programs.id', 'programs.name')
            ->orderBy('total', 'desc')
            ->get();

        return view('finance.reports.revenue', compact('monthlyRevenue', 'programRevenue'));
    }
}

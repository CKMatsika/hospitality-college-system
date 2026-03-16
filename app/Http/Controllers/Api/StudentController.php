<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Get student profile information.
     */
    public function profile(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        return response()->json([
            'student' => [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'email' => $student->email,
                'phone' => $student->phone,
                'program' => $student->program ? [
                    'name' => $student->program->name,
                    'duration' => $student->program->duration,
                ] : null,
                'status' => $student->status,
                'admission_date' => $student->admission_date,
            ]
        ]);
    }

    /**
     * Get student grades.
     */
    public function grades(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $grades = $student->grades()
            ->with(['course', 'exam'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'course' => $grade->course ? $grade->course->name : 'N/A',
                    'exam' => $grade->exam ? $grade->exam->title : 'N/A',
                    'score' => $grade->score,
                    'percentage' => $grade->percentage,
                    'grade' => $grade->grade,
                    'created_at' => $grade->created_at->format('M d, Y'),
                ];
            });

        return response()->json(['grades' => $grades]);
    }

    /**
     * Get student attendance.
     */
    public function attendance(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $attendance = $student->attendances()
            ->with(['course'])
            ->orderBy('date', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'course' => $attendance->course ? $attendance->course->name : 'N/A',
                    'date' => $attendance->date->format('M d, Y'),
                    'status' => $attendance->status,
                    'check_in' => $attendance->check_in?->format('h:i A'),
                    'check_out' => $attendance->check_out?->format('h:i A'),
                ];
            });

        return response()->json(['attendance' => $attendance]);
    }

    /**
     * Get student fees and payment status.
     */
    public function fees(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $fees = $student->fees()
            ->with(['feeStructure', 'feePayments'])
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function ($fee) {
                return [
                    'id' => $fee->id,
                    'fee_type' => $fee->feeStructure ? $fee->feeStructure->name : 'N/A',
                    'amount' => $fee->amount,
                    'paid' => $fee->paid,
                    'balance' => $fee->balance,
                    'due_date' => $fee->due_date?->format('M d, Y'),
                    'status' => $fee->balance <= 0 ? 'paid' : 'pending',
                    'payments' => $fee->feePayments->map(function ($payment) {
                        return [
                            'amount' => $payment->amount,
                            'method' => $payment->payment_method,
                            'date' => $payment->payment_date->format('M d, Y'),
                            'reference' => $payment->reference_number,
                        ];
                    }),
                ];
            });

        $summary = [
            'total_billed' => $student->fees->sum('amount'),
            'total_paid' => $student->fees->sum('paid'),
            'total_balance' => $student->fees->sum('balance'),
        ];

        return response()->json([
            'fees' => $fees,
            'summary' => $summary
        ]);
    }

    /**
     * Get student schedule/timetable.
     */
    public function schedule(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        // This would typically come from course enrollments or timetable
        $schedule = collect(); // Implementation would go here

        return response()->json(['schedule' => $schedule]);
    }
}

<?php

namespace App\Services;

use App\Models\AcademicTerm;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentRegistrationService
{
    public function updateRegistrationStatus(Student $student): void
    {
        $currentTermId = AcademicTerm::query()->where('is_current', true)->value('id');

        $feesQuery = $student->fees()->with('feeStructure');
        if ($currentTermId) {
            $feesQuery->where('academic_term_id', $currentTermId);
        }

        $fees = $feesQuery->get();

        $mandatoryFees = $fees->filter(function ($fee) {
            return (bool) optional($fee->feeStructure)->is_mandatory;
        });

        $totalDue = $mandatoryFees->sum(function ($fee) {
            return (float) $fee->amount - (float) ($fee->discount ?? 0);
        });

        $totalPaid = $mandatoryFees->sum(function ($fee) {
            return (float) ($fee->paid ?? 0);
        });

        if ($totalDue <= 0) {
            $student->forceFill([
                'registration_status' => 'accepted_pending_payment',
                'registration_completed_at' => null,
            ])->save();

            return;
        }

        if ($totalPaid >= $totalDue) {
            $student->forceFill([
                'registration_status' => 'registered',
                'registration_completed_at' => $student->registration_completed_at ?? now(),
            ])->save();

            return;
        }

        if ($totalPaid > 0) {
            $student->forceFill([
                'registration_status' => 'partially_paid',
                'registration_completed_at' => null,
            ])->save();

            return;
        }

        $student->forceFill([
            'registration_status' => 'accepted_pending_payment',
            'registration_completed_at' => null,
        ])->save();
    }
}

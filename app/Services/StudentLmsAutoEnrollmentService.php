<?php

namespace App\Services;

use App\Models\LmsCourse;
use App\Models\LmsEnrollment;
use App\Models\Student;

class StudentLmsAutoEnrollmentService
{
    public function autoEnrollForStudent(Student $student): void
    {
        $user = $student->user;
        if (!$user) {
            return;
        }

        if (!$student->program_id) {
            return;
        }

        $courses = LmsCourse::query()
            ->whereHas('course', function ($query) use ($student) {
                $query->where('program_id', $student->program_id);
            })
            ->get();

        foreach ($courses as $course) {
            LmsEnrollment::firstOrCreate([
                'lms_course_id' => $course->id,
                'user_id' => $user->id,
            ], [
                'progress' => 0,
                'completed_at' => null,
            ]);
        }
    }
}

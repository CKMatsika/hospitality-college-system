<?php

namespace App\Http\Controllers;

use App\Models\LmsCourse;
use App\Models\LmsEnrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentLmsEnrollmentController extends Controller
{
    public function store(Request $request, Student $student)
    {
        $validated = $request->validate([
            'lms_course_id' => 'required|exists:lms_courses,id',
        ]);

        $student->loadMissing('user');
        if (!$student->user) {
            return redirect()->back()->with('error', 'Student user account not found.');
        }

        $course = LmsCourse::find($validated['lms_course_id']);

        if ($student->program_id && $course?->course && $course->course->program_id !== $student->program_id) {
            return redirect()->back()->with('error', 'Course is not linked to the student\'s program.');
        }

        LmsEnrollment::firstOrCreate([
            'lms_course_id' => $course->id,
            'user_id' => $student->user->id,
        ], [
            'progress' => 0,
            'completed_at' => null,
        ]);

        return redirect()->back()->with('success', 'LMS enrollment added.');
    }

    public function destroy(Student $student, LmsEnrollment $enrollment)
    {
        $student->loadMissing('user');
        if (!$student->user) {
            return redirect()->back()->with('error', 'Student user account not found.');
        }

        if ((int) $enrollment->user_id !== (int) $student->user->id) {
            abort(404);
        }

        $enrollment->delete();

        return redirect()->back()->with('success', 'LMS enrollment removed.');
    }
}

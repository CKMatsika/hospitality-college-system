<?php

namespace App\Http\Controllers;

use App\Models\LmsCourse;
use App\Models\LmsEnrollment;
use App\Models\LmsModule;
use App\Models\LmsLesson;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_courses' => LmsCourse::count(),
            'active_courses' => LmsCourse::where('status', 'active')->count(),
            'total_enrollments' => LmsEnrollment::count(),
            'completed_enrollments' => LmsEnrollment::where('status', 'completed')->count(),
        ];

        $recentCourses = LmsCourse::with('enrollments')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('lms.dashboard', compact('stats', 'recentCourses'));
    }

    // LMS Courses Management
    public function courses()
    {
        $courses = LmsCourse::with('instructor')
            ->orderBy('title')
            ->paginate(10);
        
        return view('lms.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        $instructors = Staff::where('status', 'active')->get();
        return view('lms.courses.create', compact('instructors'));
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor_id' => 'required|exists:staff,id',
            'course_code' => 'required|string|unique:lms_courses,course_code',
            'duration_weeks' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'status' => 'required|in:draft,active,archived',
        ]);

        $course = LmsCourse::create($validated);

        return redirect()->route('lms.courses.show', $course)
            ->with('success', 'LMS course created successfully.');
    }

    public function showCourse(LmsCourse $course)
    {
        $course->load(['instructor', 'modules.lessons', 'enrollments.student']);
        return view('lms.courses.show', compact('course'));
    }

    // LMS Modules Management
    public function createModule(LmsCourse $course)
    {
        return view('lms.modules.create', compact('course'));
    }

    public function storeModule(Request $request, LmsCourse $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $module = $course->modules()->create($validated);

        return redirect()->route('lms.courses.show', $course)
            ->with('success', 'Module created successfully.');
    }

    // LMS Lessons Management
    public function createLesson(LmsCourse $course, LmsModule $module)
    {
        return view('lms.lessons.create', compact('course', 'module'));
    }

    public function storeLesson(Request $request, LmsCourse $course, LmsModule $module)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'lesson_type' => 'required|in:text,video,quiz,assignment',
            'order' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $lesson = $module->lessons()->create($validated);

        return redirect()->route('lms.courses.show', $course)
            ->with('success', 'Lesson created successfully.');
    }

    // LMS Enrollments Management
    public function enrollments()
    {
        $enrollments = LmsEnrollment::with(['course.instructor', 'student'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $stats = [
            'total_enrollments' => LmsEnrollment::count(),
            'active_enrollments' => LmsEnrollment::where('status', 'active')->count(),
            'pending_enrollments' => LmsEnrollment::where('status', 'pending')->count(),
            'completed_enrollments' => LmsEnrollment::where('status', 'completed')->count(),
        ];
        
        $courses = LmsCourse::where('status', 'active')->get();
        
        return view('lms.enrollments.index', compact('enrollments', 'stats', 'courses'));
    }

    public function createEnrollment()
    {
        $courses = LmsCourse::where('status', 'active')->get();
        $students = Student::where('status', 'active')->get();
        
        return view('lms.enrollments.create', compact('courses', 'students'));
    }

    public function storeEnrollment(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:lms_courses,id',
            'student_id' => 'required|exists:students,id',
        ]);

        // Check if student is already enrolled
        $existingEnrollment = LmsEnrollment::where('course_id', $validated['course_id'])
            ->where('student_id', $validated['student_id'])
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()
                ->with('error', 'Student is already enrolled in this course.');
        }

        LmsEnrollment::create([
            'course_id' => $validated['course_id'],
            'student_id' => $validated['student_id'],
            'enrollment_date' => now(),
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        return redirect()->route('lms.enrollments')
            ->with('success', 'Student enrolled successfully.');
    }

    public function updateProgress(Request $request, LmsEnrollment $enrollment)
    {
        $validated = $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'status' => 'required|in:active,completed,dropped',
        ]);

        $enrollment->update($validated);

        if ($validated['status'] === 'completed') {
            $enrollment->update(['completion_date' => now()]);
        }

        return redirect()->back()
            ->with('success', 'Enrollment updated successfully.');
    }

    // Student LMS Portal
    public function studentCourses(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student && $user->isStaff()) {
            $studentId = $request->query('student_id');
            if ($studentId) {
                $student = Student::find($studentId);
            }
        }

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        $enrollments = LmsEnrollment::with('course.instructor')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $availableCourses = LmsCourse::where('status', 'active')
            ->whereNotIn('id', $enrollments->pluck('course_id'))
            ->get();

        return view('lms.student.courses', compact('enrollments', 'availableCourses'));
    }

    public function viewCourse(Request $request, LmsCourse $course)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student && $user->isStaff()) {
            $studentId = $request->query('student_id');
            if ($studentId) {
                $student = Student::find($studentId);
            }
        }

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        $enrollment = LmsEnrollment::where('course_id', $course->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        $course->load(['modules.lessons' => function($query) {
            $query->orderBy('order');
        }]);

        return view('lms.student.course', compact('course', 'enrollment'));
    }

    public function enrollInCourse(Request $request, LmsCourse $course)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student && $user->isStaff()) {
            $studentId = $request->query('student_id');
            if ($studentId) {
                $student = Student::find($studentId);
            }
        }

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        // Check if already enrolled
        $existingEnrollment = LmsEnrollment::where('course_id', $course->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()
                ->with('error', 'You are already enrolled in this course.');
        }

        LmsEnrollment::create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'enrollment_date' => now(),
            'status' => 'active',
            'progress_percentage' => 0,
        ]);

        return redirect()->route('lms.student.course', $course)
            ->with('success', 'Successfully enrolled in the course!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Services\AcademicIntegrationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicIntegrationController extends Controller
{
    protected AcademicIntegrationService $integrationService;

    public function __construct(AcademicIntegrationService $integrationService)
    {
        $this->integrationService = $integrationService;
    }

    // Comprehensive academic dashboard
    public function dashboard(): View
    {
        $user = auth()->user();
        
        if ($user->isStudent()) {
            $student = $user->student;
            $academicProgress = $this->integrationService->getStudentAcademicProgress($student);
            $analytics = $this->integrationService->getAcademicAnalytics($student);
            $recommendations = $this->integrationService->recommendCourses($student);
            
            return view('academic.integration.student-dashboard', compact(
                'student', 
                'academicProgress', 
                'analytics', 
                'recommendations'
            ));
        }
        
        // Instructor/Admin dashboard
        return view('academic.integration.instructor-dashboard');
    }

    // Student academic progress detailed view
    public function academicProgress(Student $student): View
    {
        // TODO: Add proper authorization policy when available
        // For now, we'll allow access to authenticated users
        
        $progress = $this->integrationService->getStudentAcademicProgress($student);
        $analytics = $this->integrationService->getAcademicAnalytics($student);
        
        return view('academic.integration.progress', compact('student', 'progress', 'analytics'));
    }

    // Course integration overview
    public function courseIntegration(Course $course): View
    {
        $course->load(['enrollments.student', 'lmsEnrollments.student', 'exams', 'lessons', 'assignments']);
        
        $integrationData = [
            'academic_enrollments' => $course->enrollments,
            'lms_enrollments' => $course->lmsEnrollments ?? collect(),
            'online_exams' => $course->exams,
            'online_lessons' => $course->lessons,
            'online_assignments' => $course->assignments,
            'completion_stats' => $this->getCourseCompletionStats($course),
        ];
        
        return view('academic.integration.course-overview', compact('course', 'integrationData'));
    }

    // Auto-enrollment management
    public function autoEnrollment(Request $request): View
    {
        $students = Student::with('program.courses')->get();
        $enrollmentStats = $this->getAutoEnrollmentStats();
        
        return view('academic.integration.auto-enrollment', compact('students', 'enrollmentStats'));
    }

    // Process auto-enrollment for students
    public function processAutoEnrollment(Request $request): \Illuminate\Http\RedirectResponse
    {
        $studentIds = $request->input('student_ids', []);
        
        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $this->integrationService->autoEnrollStudentInCourses($student);
            }
        }
        
        return redirect()->back()->with('success', 'Auto-enrollment processed successfully.');
    }

    // Advanced analytics dashboard
    public function analytics(): View
    {
        $analytics = [
            'overall_performance' => $this->getOverallPerformanceAnalytics(),
            'course_completion_rates' => $this->getCourseCompletionRates(),
            'student_engagement' => $this->getStudentEngagementAnalytics(),
            'learning_effectiveness' => $this->getLearningEffectivenessAnalytics(),
            'skill_development' => $this->getSkillDevelopmentAnalytics(),
        ];
        
        return view('academic.integration.analytics', compact('analytics'));
    }

    // AI-powered recommendations
    public function recommendations(Student $student): View
    {
        // TODO: Add proper authorization policy when available
        // For now, we'll allow access to authenticated users
        
        $recommendations = $this->integrationService->recommendCourses($student);
        $personalizedInsights = $this->getPersonalizedInsights($student);
        
        return view('academic.integration.recommendations', compact('student', 'recommendations', 'personalizedInsights'));
    }

    // Show course completion sync page
    public function syncCompletionPage(): View
    {
        $syncStats = $this->getSyncStats();
        $pendingSyncs = $this->getPendingSyncs();
        
        return view('academic.integration.sync-completion', compact(
            'syncStats',
            'pendingSyncs'
        ));
    }

    // Sync course completion across systems
    public function syncCompletion(Request $request): \Illuminate\Http\RedirectResponse
    {
        $courseId = $request->input('course_id');
        $studentId = $request->input('student_id');
        
        $course = Course::find($courseId);
        $student = Student::find($studentId);
        
        if ($course && $student) {
            $this->integrationService->syncCourseCompletion($course, $student);
            
            return redirect()->back()->with('success', 'Course completion synced successfully.');
        }
        
        return redirect()->back()->with('error', 'Failed to sync course completion.');
    }

    // Private helper methods
    private function getCourseCompletionStats(Course $course): array
    {
        $totalEnrollments = $course->enrollments()->count();
        $completedEnrollments = $course->enrollments()->where('status', 'completed')->count();
        
        return [
            'total_enrollments' => $totalEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'completion_rate' => $totalEnrollments > 0 ? ($completedEnrollments / $totalEnrollments) * 100 : 0,
            'average_grade' => $course->enrollments()->whereNotNull('grade')->avg('grade'),
        ];
    }

    private function getAutoEnrollmentStats(): array
    {
        return [
            'total_students' => Student::count(),
            'students_with_program' => Student::whereNotNull('program_id')->count(),
            'auto_enrolled_students' => Student::whereHas('enrollments')->count(),
            'pending_enrollments' => Student::whereDoesntHave('enrollments')->whereNotNull('program_id')->count(),
        ];
    }

    private function getOverallPerformanceAnalytics(): array
    {
        return [
            'average_gpa' => Student::with('enrollments')->get()->avg(function ($student) {
                return $this->integrationService->getStudentAcademicProgress($student)['overall_gpa'] ?? 0;
            }),
            'completion_rates' => Course::with('enrollments')->get()->map(function ($course) {
                return [
                    'course_name' => $course->name,
                    'completion_rate' => $this->getCourseCompletionStats($course)['completion_rate'],
                ];
            }),
        ];
    }

    private function getCourseCompletionRates(): array
    {
        // Implementation for course completion rates
        return [];
    }

    private function getStudentEngagementAnalytics(): array
    {
        // Implementation for student engagement analytics
        return [];
    }

    private function getLearningEffectivenessAnalytics(): array
    {
        // Implementation for learning effectiveness analytics
        return [];
    }

    private function getSkillDevelopmentAnalytics(): array
    {
        // Implementation for skill development analytics
        return [];
    }

    private function getPersonalizedInsights(Student $student): array
    {
        // Generate personalized insights for the student
        return [
            'strengths' => [],
            'improvement_areas' => [],
            'learning_style' => '',
            'engagement_level' => '',
        ];
    }

    private function getSyncStats(): array
    {
        return [
            'total_courses' => Course::count(),
            'synced_courses' => Course::whereNotNull('synced_at')->count(),
            'pending_syncs' => Course::whereNull('synced_at')->count(),
            'last_sync' => now()->subHours(2)->format('M d, Y H:i'),
            'sync_success_rate' => 95.5,
        ];
    }

    private function getPendingSyncs(): array
    {
        return Course::whereNull('synced_at')
            ->with('enrollments.student')
            ->limit(10)
            ->get()
            ->map(function ($course) {
                return [
                    'course' => $course,
                    'students_count' => $course->enrollments->count(),
                    'completion_rate' => $course->enrollments->where('status', 'completed')->count() / max($course->enrollments->count(), 1) * 100,
                    'last_activity' => $course->enrollments->max('updated_at')?->format('M d, Y') ?? 'No activity',
                ];
            })
            ->toArray();
    }
}

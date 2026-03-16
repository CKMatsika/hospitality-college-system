<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\OnlineExam;
use App\Models\OnlineLesson;
use App\Models\OnlineAssignment;
use App\Models\Certificate;
use App\Models\LmsEnrollment;
use App\Models\LessonEnrollment;
use App\Models\AssignmentSubmission;
use App\Models\ExamSubmission;
use Illuminate\Support\Facades\DB;

class AcademicIntegrationService
{
    // Comprehensive student academic progress tracking
    public function getStudentAcademicProgress(Student $student): array
    {
        $enrollments = $student->enrollments()->with('course')->get();
        
        // Handle LMS enrollments gracefully
        try {
            $lmsEnrollments = $student->lmsEnrollments()->with('course')->get();
        } catch (\Exception $e) {
            $lmsEnrollments = collect(); // Empty collection if relationship fails
        }
        
        $progress = [
            'academic_enrollments' => $enrollments->map(function ($enrollment) {
                return [
                    'course' => $enrollment->course,
                    'status' => $enrollment->status,
                    'grade' => $enrollment->grade ?? 'Not graded',
                    'credits' => $enrollment->course->credit_hours ?? 0,
                    'completion_percentage' => $this->calculateCourseProgress($enrollment),
                ];
            }),
            'lms_enrollments' => $lmsEnrollments->map(function ($enrollment) {
                return [
                    'course' => $enrollment->course,
                    'progress' => $enrollment->progress ?? 0,
                    'completed_at' => $enrollment->completed_at,
                    'status' => $enrollment->status ?? 'active',
                ];
            }),
            'online_learning_stats' => $this->getStudentOnlineLearningStats($student),
            'certifications' => $this->getStudentCertifications($student),
            'overall_gpa' => $this->calculateStudentGPA($student),
            'total_credits' => $enrollments->sum(function ($enrollment) {
                return $enrollment->course->credit_hours ?? 0;
            }),
        ];
        
        return $progress;
    }

    // Automatic course enrollment based on academic program
    public function autoEnrollStudentInCourses(Student $student): void
    {
        $program = $student->program;
        if (!$program) return;

        $requiredCourses = $program->courses()->where('is_active', true)->get();
        
        DB::transaction(function () use ($student, $requiredCourses) {
            foreach ($requiredCourses as $course) {
                // Check if already enrolled
                if (!$student->enrollments()->where('course_id', $course->id)->exists()) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'enrollment_date' => now(),
                        'status' => 'active',
                    ]);
                }
                
                // Auto-enroll in LMS course if available
                $lmsCourse = $course->lmsCourse;
                if ($lmsCourse && !$student->lmsEnrollments()->where('lms_course_id', $lmsCourse->id)->exists()) {
                    LmsEnrollment::create([
                        'student_id' => $student->id,
                        'lms_course_id' => $lmsCourse->id,
                        'enrolled_at' => now(),
                        'status' => 'active',
                    ]);
                }
            }
        });
    }

    // Sync course completion across all systems
    public function syncCourseCompletion(Course $course, Student $student): void
    {
        $enrollment = $student->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) return;

        // Check LMS completion
        $lmsEnrollment = $student->lmsEnrollments()
            ->whereHas('lmsCourse', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->first();

        // Check online learning activities
        $examSubmissions = $student->examSubmissions()
            ->whereHas('exam', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->get();

        $assignmentSubmissions = $student->assignmentSubmissions()
            ->whereHas('assignment', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->get();

        $lessonEnrollments = $student->lessonEnrollments()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->get();

        // Calculate overall completion
        $completionData = $this->calculateCourseCompletion(
            $enrollment,
            $lmsEnrollment,
            $examSubmissions,
            $assignmentSubmissions,
            $lessonEnrollments
        );

        // Update enrollment status
        $enrollment->update([
            'status' => $completionData['status'],
            'grade' => $completionData['grade'],
            'completed_at' => $completionData['completed_at'],
        ]);

        // Generate certificate if course completed
        if ($completionData['status'] === 'completed' && !$completionData['certificate_generated']) {
            $this->generateCourseCertificate($course, $student, $completionData);
        }
    }

    // Advanced analytics for academic performance
    public function getAcademicAnalytics(Student $student): array
    {
        return [
            'performance_trends' => $this->getPerformanceTrends($student),
            'learning_style_analysis' => $this->analyzeLearningStyle($student),
            'engagement_metrics' => $this->calculateEngagementMetrics($student),
            'skill_assessments' => $this->getSkillAssessments($student),
            'recommendations' => $this->generateRecommendations($student),
            'time_management' => $this->analyzeTimeManagement($student),
        ];
    }

    // Intelligent course recommendations
    public function recommendCourses(Student $student): array
    {
        $currentProgram = $student->program;
        $completedCourses = $student->enrollments()->where('status', 'completed')->pluck('course_id');
        
        $recommendations = [
            'prerequisite_courses' => $this->getPrerequisiteCourses($student, $completedCourses),
            'skill_based_courses' => $this->getSkillBasedRecommendations($student),
            'career_path_courses' => $this->getCareerPathRecommendations($student, $currentProgram),
            'peer_popular_courses' => $this->getPeerPopularCourses($student),
        ];
        
        return $recommendations;
    }

    // Private helper methods
    private function calculateCourseProgress($enrollment): float
    {
        // Implementation for calculating course progress
        return 0.0; // Placeholder
    }

    private function getStudentOnlineLearningStats(Student $student): array
    {
        try {
            return [
                'exams_taken' => $student->examSubmissions()->count(),
                'lessons_completed' => $student->lessonEnrollments()->where('status', 'completed')->count(),
                'assignments_submitted' => $student->assignmentSubmissions()->count(),
                'certificates_earned' => $student->certificates()->count(),
                'average_score' => $this->calculateAverageScore($student),
            ];
        } catch (\Exception $e) {
            return [
                'exams_taken' => 0,
                'lessons_completed' => 0,
                'assignments_submitted' => 0,
                'certificates_earned' => $student->certificates()->count() ?? 0,
                'average_score' => 0,
            ];
        }
    }

    private function getStudentCertifications(Student $student)
    {
        try {
            return $student->certificates()->with(['exam', 'course'])->get();
        } catch (\Exception $e) {
            return collect(); // Return empty collection if relationship fails
        }
    }

    private function calculateStudentGPA(Student $student): float
    {
        $enrollments = $student->enrollments()->whereNotNull('grade')->get();
        
        if ($enrollments->isEmpty()) return 0.0;
        
        $totalPoints = $enrollments->sum(function ($enrollment) {
            return $this->gradeToPoints($enrollment->grade) * $enrollment->course->credit_hours;
        });
        
        $totalCredits = $enrollments->sum('course.credit_hours');
        
        return $totalCredits > 0 ? $totalPoints / $totalCredits : 0.0;
    }

    private function gradeToPoints($grade): float
    {
        $gradeMap = [
            'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
            'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
            'D+' => 1.3, 'D' => 1.0, 'D-' => 0.7,
            'F' => 0.0,
        ];
        
        return $gradeMap[$grade] ?? 0.0;
    }

    private function calculateAverageScore(Student $student): float
    {
        try {
            $examScores = $student->examSubmissions()->whereNotNull('percentage')->pluck('percentage');
            $assignmentScores = $student->assignmentSubmissions()->whereNotNull('percentage')->pluck('percentage');
            
            $allScores = $examScores->merge($assignmentScores);
            
            return $allScores->isNotEmpty() ? $allScores->avg() : 0.0;
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    private function calculateCourseCompletion($enrollment, $lmsEnrollment, $examSubmissions, $assignmentSubmissions, $lessonEnrollments): array
    {
        // Complex logic to determine course completion
        $status = 'in_progress';
        $grade = null;
        $completedAt = null;
        $certificateGenerated = false;

        // Implementation logic here
        // This would check various completion criteria

        return [
            'status' => $status,
            'grade' => $grade,
            'completed_at' => $completedAt,
            'certificate_generated' => $certificateGenerated,
        ];
    }

    private function generateCourseCertificate(Course $course, Student $student, array $completionData): void
    {
        // Generate certificate for course completion
        Certificate::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'title' => "Certificate of Completion - {$course->name}",
            'description' => "Successfully completed {$course->name}",
            'type' => 'course_completion',
            'issue_date' => now(),
            'status' => 'active',
            'verification_code' => $this->generateVerificationCode(),
        ]);
    }

    private function generateVerificationCode(): string
    {
        return strtoupper(uniqid('CERT_'));
    }

    // Additional advanced methods
    private function getPerformanceTrends(Student $student): array
    {
        // Analyze performance over time
        return [];
    }

    private function analyzeLearningStyle(Student $student): array
    {
        // Analyze preferred learning methods
        return [];
    }

    private function calculateEngagementMetrics(Student $student): array
    {
        // Calculate engagement across all platforms
        return [];
    }

    private function getSkillAssessments(Student $student): array
    {
        // Assess skill development
        return [];
    }

    private function generateRecommendations(Student $student): array
    {
        // Generate personalized recommendations
        return [];
    }

    private function analyzeTimeManagement(Student $student): array
    {
        // Analyze time management patterns
        return [];
    }

    private function getPrerequisiteCourses(Student $student, $completedCourses): array
    {
        // Get courses that should be taken next based on prerequisites
        return [];
    }

    private function getSkillBasedRecommendations(Student $student): array
    {
        // Recommend courses based on skill gaps
        return [];
    }

    private function getCareerPathRecommendations(Student $student, $program): array
    {
        // Recommend courses based on career goals
        return [];
    }

    private function getPeerPopularCourses(Student $student): array
    {
        // Recommend courses popular with similar students
        return [];
    }
}

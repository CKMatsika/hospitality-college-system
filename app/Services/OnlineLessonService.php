<?php

namespace App\Services;

use App\Models\OnlineLesson;
use App\Models\LessonEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OnlineLessonService
{
    public function createLesson(array $data): OnlineLesson
    {
        return OnlineLesson::create($data);
    }

    public function updateLesson(OnlineLesson $lesson, array $data): void
    {
        $lesson->update($data);
    }

    public function deleteLesson(OnlineLesson $lesson): void
    {
        $lesson->delete();
    }

    public function enrollStudent(OnlineLesson $lesson, User $student, array $data): void
    {
        DB::transaction(function () use ($lesson, $student, $data) {
            LessonEnrollment::create([
                'lesson_id' => $lesson->id,
                'student_id' => $student->id,
                'enrolled_at' => now(),
                'status' => 'enrolled',
                'notes' => $data['notes'] ?? null,
            ]);
        });
    }

    public function completeLesson(OnlineLesson $lesson, User $student, array $data): void
    {
        DB::transaction(function () use ($lesson, $student, $data) {
            $enrollment = LessonEnrollment::where('lesson_id', $lesson->id)
                ->where('student_id', $student->id)
                ->where('status', '!=', 'completed')
                ->first();

            if ($enrollment) {
                $enrollment->update([
                    'completed_at' => now(),
                    'progress_percentage' => 100.00,
                    'time_spent_minutes' => $data['time_spent_minutes'],
                    'status' => 'completed',
                    'notes' => $data['notes'] ?? $enrollment->notes,
                ]);
            }
        });
    }

    public function getStudentProgress(OnlineLesson $lesson, User $student): ?LessonEnrollment
    {
        return $lesson->enrollments()
            ->where('student_id', $student->id)
            ->first();
    }

    public function getLessonStatistics(OnlineLesson $lesson): array
    {
        $totalEnrollments = $lesson->enrollments()->count();
        $completedEnrollments = $lesson->enrollments()->where('status', 'completed')->count();
        $inProgressEnrollments = $lesson->enrollments()->where('status', 'in_progress')->count();
        
        return [
            'total_enrollments' => $totalEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'in_progress_enrollments' => $inProgressEnrollments,
            'completion_rate' => $totalEnrollments > 0 ? ($completedEnrollments / $totalEnrollments) * 100 : 0,
        ];
    }

    public function getStudentLessons(User $student): array
    {
        return OnlineLesson::with(['enrollments' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getInstructorLessons(User $instructor): array
    {
        return OnlineLesson::with(['course', 'enrollments'])
            ->where('instructor_id', $instructor->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

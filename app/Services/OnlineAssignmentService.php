<?php

namespace App\Services;

use App\Models\OnlineAssignment;
use App\Models\AssignmentSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OnlineAssignmentService
{
    public function createAssignment(array $data): OnlineAssignment
    {
        return OnlineAssignment::create($data);
    }

    public function updateAssignment(OnlineAssignment $assignment, array $data): void
    {
        $assignment->update($data);
    }

    public function deleteAssignment(OnlineAssignment $assignment): void
    {
        $assignment->delete();
    }

    public function submitAssignment(OnlineAssignment $assignment, User $student, array $data): AssignmentSubmission
    {
        return DB::transaction(function () use ($assignment, $student, $data) {
            $submission = AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $student->id,
                'submitted_at' => now(),
                'submission_text' => $data['submission_text'] ?? null,
                'attachment_files' => $data['attachment_files'] ?? null,
                'is_late' => $assignment->deadline && now()->gt($assignment->deadline),
                'late_penalty_applied' => $this->calculateLatePenalty($assignment),
            ]);

            // Auto-grade if it's a simple assignment
            if ($assignment->total_marks && $submission->submission_text) {
                $this->autoGradeSubmission($submission, $assignment);
            }

            return $submission;
        });
    }

    public function gradeSubmission(AssignmentSubmission $submission, array $grades): void
    {
        DB::transaction(function () use ($submission, $grades) {
            $submission->update([
                'score' => $grades['score'],
                'percentage' => $grades['percentage'],
                'feedback' => $grades['feedback'],
                'status' => $grades['status'],
            ]);
        });
    }

    protected function calculateLatePenalty(OnlineAssignment $assignment): float
    {
        if (!$assignment->allow_late_submission || !$assignment->deadline || !now()->gt($assignment->deadline)) {
            return 0.00;
        }

        $minutesLate = now()->diffInMinutes($assignment->deadline);
        
        return ($assignment->total_marks * $assignment->late_penalty_percentage / 100) * ($minutesLate / (24 * 60)); // Daily penalty
    }

    protected function autoGradeSubmission(AssignmentSubmission $submission, OnlineAssignment $assignment): void
    {
        // Simple auto-grading based on submission text
        $score = min(strlen($submission->submission_text), $assignment->total_marks);
        $percentage = ($score / $assignment->total_marks) * 100;

        $submission->update([
            'score' => $score,
            'percentage' => $percentage,
            'status' => 'graded',
        ]);
    }

    public function getStudentAssignments(User $student): array
    {
        return OnlineAssignment::with(['submissions' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->where('is_published', true)
            ->orderBy('deadline', 'asc')
            ->get();
    }

    public function getInstructorAssignments(User $instructor): array
    {
        return OnlineAssignment::with(['course', 'submissions'])
            ->where('instructor_id', $instructor->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAssignmentStatistics(OnlineAssignment $assignment): array
    {
        $totalSubmissions = $assignment->submissions()->count();
        $gradedSubmissions = $assignment->submissions()->where('status', 'graded')->count();
        $passedSubmissions = $assignment->submissions()->where('status', 'graded')->where('percentage', '>=', 50)->count();
        
        return [
            'total_submissions' => $totalSubmissions,
            'graded_submissions' => $gradedSubmissions,
            'passed_submissions' => $passedSubmissions,
            'pass_rate' => $gradedSubmissions > 0 ? ($passedSubmissions / $gradedSubmissions) * 100 : 0,
        ];
    }
}

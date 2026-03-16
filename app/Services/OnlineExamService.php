<?php

namespace App\Services;

use App\Models\OnlineExam;
use App\Models\ExamQuestion;
use App\Models\ExamSubmission;
use App\Models\ExamAnswer;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OnlineExamService
{
    public function createExam(array $data): OnlineExam
    {
        return OnlineExam::create($data);
    }

    public function addQuestions(OnlineExam $exam, array $questions): void
    {
        DB::transaction(function () use ($exam, $questions) {
            foreach ($questions as $index => $questionData) {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'marks' => $questionData['marks'],
                    'order' => $index + 1,
                    'options' => $questionData['options'] ?? null,
                    'correct_answer' => $questionData['correct_answer'],
                    'explanation' => $questionData['explanation'] ?? null,
                ]);
            }
        });
    }

    public function publishExam(OnlineExam $exam): void
    {
        $exam->update(['is_published' => true]);
    }

    public function canStudentTakeExam(OnlineExam $exam, User $student): bool
    {
        // Check if exam is published
        if (!$exam->is_published) {
            return false;
        }

        // Check if exam is within time window
        if (!$exam->hasStarted() || $exam->hasEnded()) {
            return false;
        }

        // Check if student is enrolled in the course
        if (!$exam->course || !$exam->course->students()->where('student_id', $student->id)->exists()) {
            return false;
        }

        // Check attempt limits
        $previousAttempts = $exam->submissions()
            ->where('student_id', $student->id)
            ->where('status', '!=', 'in_progress')
            ->count();

        if ($previousAttempts >= $exam->max_attempts) {
            return false;
        }

        return true;
    }

    public function startExam(OnlineExam $exam, User $student): ExamSubmission
    {
        return DB::transaction(function () use ($exam, $student) {
            return ExamSubmission::create([
                'exam_id' => $exam->id,
                'student_id' => $student->id,
                'start_time' => now(),
                'status' => 'in_progress',
                'attempt_number' => $exam->submissions()
                    ->where('student_id', $student->id)
                    ->where('status', '!=', 'in_progress')
                    ->count() + 1,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }

    public function submitExam(OnlineExam $exam, User $student, array $answers): ExamSubmission
    {
        return DB::transaction(function () use ($exam, $student, $answers) {
            $submission = ExamSubmission::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('status', 'in_progress')
                ->first();

            if (!$submission) {
                throw new \Exception('No active exam submission found.');
            }

            // Update submission
            $submission->update([
                'end_time' => now(),
                'status' => 'submitted',
            ]);

            // Save answers
            foreach ($answers as $answer) {
                ExamAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                ]);
            }

            // Auto-grade objective questions
            $this->autoGradeObjectiveQuestions($submission);

            return $submission;
        });
    }

    public function gradeExam(ExamSubmission $submission, array $grades): void
    {
        DB::transaction(function () use ($submission, $grades) {
            $totalScore = 0;
            $totalMarks = 0;

            foreach ($grades as $grade) {
                $answer = ExamAnswer::where('submission_id', $submission->id)
                    ->where('question_id', $grade['question_id'])
                    ->first();

                if ($answer) {
                    $answer->update([
                        'marks_obtained' => $grade['marks_obtained'],
                        'is_correct' => $grade['is_correct'],
                    ]);

                    $totalScore += $grade['marks_obtained'];
                }

                $question = ExamQuestion::find($grade['question_id']);
                $totalMarks += $question->marks;
            }

            // Calculate percentage
            $percentage = $totalMarks > 0 ? ($totalScore / $totalMarks) * 100 : 0;

            // Update submission
            $submission->update([
                'score' => $totalScore,
                'percentage' => $percentage,
                'status' => $percentage >= $submission->exam->passing_score ? 'passed' : 'failed',
            ]);

            // Generate certificate if passed
            if ($percentage >= $submission->exam->passing_score) {
                $this->generateCertificate($submission);
            }
        });
    }

    protected function autoGradeObjectiveQuestions(ExamSubmission $submission): void
    {
        foreach ($submission->answers as $answer) {
            $question = $answer->question;
            
            if ($question->isMultipleChoice() || $question->isTrueFalse()) {
                $isCorrect = $this->evaluateObjectiveAnswer($question, $answer->answer);
                $answer->update(['is_correct' => $isCorrect]);
            }
        }
    }

    protected function evaluateObjectiveAnswer(ExamQuestion $question, string $answer): bool
    {
        if ($question->isMultipleChoice()) {
            return $answer === $question->correct_answer;
        }

        if ($question->isTrueFalse()) {
            return strtolower($answer) === strtolower($question->correct_answer);
        }

        return false;
    }

    public function generateCertificate(ExamSubmission $submission): Certificate
    {
        return DB::transaction(function () use ($submission) {
            return Certificate::create([
                'student_id' => $submission->student_id,
                'exam_id' => $submission->exam_id,
                'course_id' => $submission->exam->course_id,
                'title' => 'Certificate of Completion: ' . $submission->exam->title,
                'description' => 'Successfully completed the online exam with a score of ' . $submission->percentage . '%',
                'score' => $submission->score,
                'percentage' => $submission->percentage,
                'issue_date' => now(),
                'expiry_date' => now()->addYears(2), // Certificates expire in 2 years
                'verification_code' => strtoupper(Str::random(10)),
                'status' => 'active',
                'issued_by' => $submission->exam->instructor_id,
            ]);
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\OnlineExam;
use App\Models\ExamQuestion;
use App\Models\ExamSubmission;
use App\Models\Certificate;
use App\Services\OnlineExamService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OnlineExamController extends Controller
{
    protected OnlineExamService $examService;

    public function __construct(OnlineExamService $examService)
    {
        $this->examService = $examService;
    }

    // Dashboard for instructors
    public function index(): View
    {
        $exams = OnlineExam::with(['course', 'instructor', 'submissions'])
            ->where('instructor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('online-exams.index', compact('exams'));
    }

    // Create new exam form
    public function create(): View
    {
        $courses = auth()->user()->courses ?? collect();
        return view('online-exams.create', compact('courses'));
    }

    // Store new exam
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1',
            'allow_multiple_attempts' => 'boolean',
            'max_attempts' => 'required|integer|min:1',
            'require_proctoring' => 'boolean',
            'proctoring_instructions' => 'nullable|string',
        ]);

        $exam = $this->examService->createExam($validated + ['instructor_id' => auth()->id()]);

        return redirect()->route('online-exams.questions', $exam)
            ->with('success', 'Exam created successfully. Now add questions.');
    }

    // Show exam with questions
    public function show(OnlineExam $exam): View
    {
        $exam->load(['course', 'instructor', 'questions', 'submissions']);
        
        $this->authorize('view', $exam);
        
        return view('online-exams.show', compact('exam'));
    }

    // Questions management
    public function questions(OnlineExam $exam): View
    {
        $exam->load(['course', 'questions']);
        
        $this->authorize('update', $exam);
        
        return view('online-exams.questions', compact('exam'));
    }

    // Store questions
    public function storeQuestions(Request $request, OnlineExam $exam): RedirectResponse
    {
        $this->authorize('update', $exam);
        
        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,true_false,short_answer,essay,matching',
            'questions.*.marks' => 'required|numeric|min:0.01',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
        ]);

        $this->examService->addQuestions($exam, $validated['questions']);

        return redirect()->route('online-exams.questions', $exam)
            ->with('success', 'Questions added successfully.');
    }

    // Publish exam
    public function publish(OnlineExam $exam): RedirectResponse
    {
        $this->authorize('update', $exam);
        
        $this->examService->publishExam($exam);

        return redirect()->route('online-exams.show', $exam)
            ->with('success', 'Exam published successfully.');
    }

    // Student exam interface
    public function takeExam(OnlineExam $exam): View
    {
        $exam->load(['questions', 'course']);
        
        // Check if student can take this exam
        if (!$this->examService->canStudentTakeExam($exam, auth()->user())) {
            abort(403, 'You are not authorized to take this exam.');
        }

        // Check for existing submission
        $submission = $exam->submissions()
            ->where('student_id', auth()->id())
            ->where('status', 'in_progress')
            ->first();

        if (!$submission) {
            $submission = $this->examService->startExam($exam, auth()->user());
        }

        return view('online-exams.take', compact('exam', 'submission'));
    }

    // Submit exam
    public function submitExam(Request $request, OnlineExam $exam): RedirectResponse
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:exam_questions,id',
            'answers.*.answer' => 'required|string',
        ]);

        $submission = $this->examService->submitExam($exam, auth()->user(), $validated);

        return redirect()->route('online-exams.results', $submission)
            ->with('success', 'Exam submitted successfully.');
    }

    // Show exam results
    public function results(ExamSubmission $submission): View
    {
        $submission->load(['exam', 'exam.questions', 'answers', 'student']);
        
        $this->authorize('view', $submission);

        return view('online-exams.results', compact('submission'));
    }

    // Grade exam (instructor)
    public function grade(ExamSubmission $submission): View
    {
        $submission->load(['exam', 'exam.questions', 'answers', 'student']);
        
        $this->authorize('grade', $submission->exam);

        return view('online-exams.grade', compact('submission'));
    }

    // Save grades
    public function saveGrades(Request $request, ExamSubmission $submission): RedirectResponse
    {
        $this->authorize('grade', $submission->exam);
        
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:exam_questions,id',
            'answers.*.marks_obtained' => 'required|numeric|min:0',
            'answers.*.is_correct' => 'required|boolean',
            'answers.*.feedback' => 'nullable|string',
        ]);

        $this->examService->gradeExam($submission, $validated['answers']);

        return redirect()->route('online-exams.results', $submission)
            ->with('success', 'Exam graded successfully.');
    }

    // Generate certificate
    public function generateCertificate(ExamSubmission $submission): RedirectResponse
    {
        $submission->load(['exam', 'student']);
        
        $this->authorize('view', $submission);

        if (!$submission->hasPassed()) {
            return back()->with('error', 'Certificate cannot be generated for failed exams.');
        }

        $certificate = $this->examService->generateCertificate($submission);

        return redirect()->route('certificates.show', $certificate)
            ->with('success', 'Certificate generated successfully.');
    }
}

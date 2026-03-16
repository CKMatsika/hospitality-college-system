<?php

namespace App\Http\Controllers;

use App\Models\OnlineAssignment;
use App\Models\AssignmentSubmission;
use App\Services\OnlineAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OnlineAssignmentController extends Controller
{
    protected OnlineAssignmentService $assignmentService;

    public function __construct(OnlineAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    // Instructor dashboard
    public function index(): View
    {
        $assignments = OnlineAssignment::with(['course', 'instructor', 'submissions'])
            ->where('instructor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('online-assignments.index', compact('assignments'));
    }

    // Create new assignment form
    public function create(): View
    {
        $courses = auth()->user()->courses ?? collect();
        return view('online-assignments.create', compact('courses'));
    }

    // Store new assignment
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required|date|after:now',
            'total_marks' => 'required|numeric|min:1',
            'allow_late_submission' => 'boolean',
            'late_penalty_percentage' => 'integer|min:0|max:100',
            'instructions' => 'nullable|string',
            'attachment_files' => 'nullable|array',
        ]);

        $assignment = $this->assignmentService->createAssignment($validated + ['instructor_id' => auth()->id()]);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Assignment created successfully.');
    }

    // Show assignment details
    public function show(OnlineAssignment $assignment): View
    {
        $assignment->load(['course', 'instructor', 'submissions']);
        
        $this->authorize('view', $assignment);
        
        return view('online-assignments.show', compact('assignment'));
    }

    // Show assignment submissions
    public function submissions(OnlineAssignment $assignment): View
    {
        $assignment->load(['course', 'instructor', 'submissions.student']);
        
        $this->authorize('view', $assignment);
        
        return view('online-assignments.submissions', compact('assignment'));
    }

    // Student submit assignment
    public function submit(Request $request, OnlineAssignment $assignment): RedirectResponse
    {
        $validated = $request->validate([
            'submission_text' => 'nullable|string',
            'attachment_files' => 'nullable|array',
        ]);

        $submission = $this->assignmentService->submitAssignment($assignment, auth()->user(), $validated);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Assignment submitted successfully.');
    }

    // Grade assignment submission
    public function grade(Request $request, AssignmentSubmission $submission): View
    {
        $submission->load(['assignment', 'assignment.course', 'student']);
        
        $this->authorize('grade', $submission->assignment);

        return view('online-assignments.grade', compact('submission'));
    }

    // Save grades
    public function saveGrades(Request $request, AssignmentSubmission $submission): RedirectResponse
    {
        $this->authorize('grade', $submission->assignment);
        
        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:' . $submission->assignment->total_marks,
            'percentage' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
            'status' => 'required|in:submitted,graded,returned_for_revision',
        ]);

        $this->assignmentService->gradeSubmission($submission, $validated);

        return redirect()->route('assignments.submissions', $submission->assignment)
            ->with('success', 'Assignment graded successfully.');
    }

    // Edit assignment
    public function edit(OnlineAssignment $assignment): View
    {
        $assignment->load(['course', 'instructor']);
        
        $this->authorize('update', $assignment);
        
        $courses = auth()->user()->courses ?? collect();
        return view('online-assignments.edit', compact('assignment', 'courses'));
    }

    // Update assignment
    public function update(Request $request, OnlineAssignment $assignment): RedirectResponse
    {
        $this->authorize('update', $assignment);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required|date|after:now',
            'total_marks' => 'required|numeric|min:1',
            'allow_late_submission' => 'boolean',
            'late_penalty_percentage' => 'integer|min:0|max:100',
            'instructions' => 'nullable|string',
            'attachment_files' => 'nullable|array',
        ]);

        $this->assignmentService->updateAssignment($assignment, $validated);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Assignment updated successfully.');
    }

    // Delete assignment
    public function destroy(OnlineAssignment $assignment): RedirectResponse
    {
        $this->authorize('delete', $assignment);
        
        $this->assignmentService->deleteAssignment($assignment);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }
}

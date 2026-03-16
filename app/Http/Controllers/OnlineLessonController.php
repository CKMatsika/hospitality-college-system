<?php

namespace App\Http\Controllers;

use App\Models\OnlineLesson;
use App\Models\LessonEnrollment;
use App\Services\OnlineLessonService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OnlineLessonController extends Controller
{
    protected OnlineLessonService $lessonService;

    public function __construct(OnlineLessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    // Instructor dashboard
    public function index(): View
    {
        $lessons = OnlineLesson::with(['course', 'instructor', 'enrollments'])
            ->where('instructor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('online-lessons.index', compact('lessons'));
    }

    // Create new lesson form
    public function create(): View
    {
        $courses = auth()->user()->courses ?? collect();
        return view('online-lessons.create', compact('courses'));
    }

    // Store new lesson
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'lesson_type' => 'required|in:video,text,interactive,live_session,assignment',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'nullable|integer|min:1',
            'scheduled_start_time' => 'nullable|date',
            'scheduled_end_time' => 'nullable|date|after:scheduled_start_time',
            'allow_comments' => 'boolean',
            'order' => 'integer|min:1',
            'materials' => 'nullable|array',
        ]);

        $lesson = $this->lessonService->createLesson($validated + ['instructor_id' => auth()->id()]);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson created successfully.');
    }

    // Show lesson details
    public function show(OnlineLesson $lesson): View
    {
        $lesson->load(['course', 'instructor', 'enrollments']);
        
        $this->authorize('view', $lesson);
        
        return view('online-lessons.show', compact('lesson'));
    }

    // Edit lesson form
    public function edit(OnlineLesson $lesson): View
    {
        $lesson->load(['course', 'instructor']);
        
        $this->authorize('update', $lesson);
        
        $courses = auth()->user()->courses ?? collect();
        return view('online-lessons.edit', compact('lesson', 'courses'));
    }

    // Update lesson
    public function update(Request $request, OnlineLesson $lesson): RedirectResponse
    {
        $this->authorize('update', $lesson);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'lesson_type' => 'required|in:video,text,interactive,live_session,assignment',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'nullable|integer|min:1',
            'scheduled_start_time' => 'nullable|date',
            'scheduled_end_time' => 'nullable|date|after:scheduled_start_time',
            'allow_comments' => 'boolean',
            'order' => 'integer|min:1',
            'materials' => 'nullable|array',
        ]);

        $this->lessonService->updateLesson($lesson, $validated);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    // Delete lesson
    public function destroy(OnlineLesson $lesson): RedirectResponse
    {
        $this->authorize('delete', $lesson);
        
        $this->lessonService->deleteLesson($lesson);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson deleted successfully.');
    }

    // Student enrollment in lesson
    public function enroll(Request $request, OnlineLesson $lesson): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $this->lessonService->enrollStudent($lesson, auth()->user(), $validated);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Enrolled in lesson successfully.');
    }

    // Complete lesson
    public function complete(Request $request, OnlineLesson $lesson): RedirectResponse
    {
        $validated = $request->validate([
            'time_spent_minutes' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $this->lessonService->completeLesson($lesson, auth()->user(), $validated);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson marked as completed.');
    }

    // Student view of lesson
    public function studentView(OnlineLesson $lesson): View
    {
        $lesson->load(['course', 'instructor']);
        
        $enrollment = $lesson->enrollments()
            ->where('student_id', auth()->id())
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this lesson.');
        }

        return view('online-lessons.student-view', compact('lesson', 'enrollment'));
    }
}

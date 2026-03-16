<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('program')
            ->orderBy('name')
            ->paginate(10);
        
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $programs = Program::where('status', 'active')->get();
        return view('courses.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'program_id' => 'required|exists:programs,id',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:10',
            'duration_hours' => 'required|integer|min:1',
            'prerequisites' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['program', 'enrollments.student']);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $programs = Program::where('status', 'active')->get();
        return view('courses.edit', compact('course', 'programs'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'program_id' => 'required|exists:programs,id',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:10',
            'duration_hours' => 'required|integer|min:1',
            'prerequisites' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        // Check if course has enrollments
        if ($course->enrollments()->count() > 0) {
            return redirect()->route('courses.index')
                ->with('error', 'Cannot delete course with enrolled students.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}

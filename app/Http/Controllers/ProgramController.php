<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Department;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with('department')
            ->orderBy('name')
            ->paginate(10);
        
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('programs.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:programs,name',
            'code' => 'required|string|max:50|unique:programs,code',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'duration_years' => 'required|integer|min:1|max:10',
            'credits_required' => 'required|integer|min:1',
            'tuition_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $program = Program::create($validated);

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    public function show(Program $program)
    {
        $program->load(['department', 'students', 'courses']);
        return view('programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $departments = Department::all();
        return view('programs.edit', compact('program', 'departments'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:programs,name,' . $program->id,
            'code' => 'required|string|max:50|unique:programs,code,' . $program->id,
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'duration_years' => 'required|integer|min:1|max:10',
            'credits_required' => 'required|integer|min:1',
            'tuition_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $program->update($validated);

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        // Check if program has students
        if ($program->students()->count() > 0) {
            return redirect()->route('programs.index')
                ->with('error', 'Cannot delete program with enrolled students.');
        }

        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}

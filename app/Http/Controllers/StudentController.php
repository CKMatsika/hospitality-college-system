<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Program;
use App\Models\User;
use App\Models\LmsCourse;
use App\Models\LmsEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('program')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('students.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'program_id' => 'required|exists:programs,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'national_id' => 'required|string|unique:students,national_id',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'admission_date' => 'required|date',
            'expected_graduation' => 'nullable|date|after:admission_date',
            'medical_notes' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'program_id' => $validated['program_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'],
            'national_id' => $validated['national_id'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'country' => $validated['country'],
            'phone' => $validated['phone'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'admission_date' => $validated['admission_date'],
            'expected_graduation' => $validated['expected_graduation'],
            'medical_notes' => $validated['medical_notes'],
            'status' => 'active',
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['program', 'user', 'enrollments.course', 'fees.feeStructure', 'grades', 'attendances']);

        $lmsEnrollments = collect();
        $availableLmsCourses = collect();

        if ($student->user) {
            $lmsEnrollments = LmsEnrollment::with('course')
                ->where('user_id', $student->user->id)
                ->get();

            $availableLmsCourses = LmsCourse::query()
                ->when($student->program_id, function ($query) use ($student) {
                    $query->whereHas('course', function ($q) use ($student) {
                        $q->where('program_id', $student->program_id);
                    });
                })
                ->whereNotIn('id', $lmsEnrollments->pluck('lms_course_id'))
                ->orderBy('title')
                ->get();
        }

        return view('students.show', compact('student', 'lmsEnrollments', 'availableLmsCourses'));
    }

    public function edit(Student $student)
    {
        $programs = Program::all();
        return view('students.edit', compact('student', 'programs'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'national_id' => ['required', 'string', Rule::unique('students')->ignore($student->id)],
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'expected_graduation' => 'nullable|date|after:admission_date',
            'medical_notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,graduated,suspended',
        ]);

        $student->update($validated);

        // Update user name if changed
        if ($student->user) {
            $student->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name']
            ]);
        }

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Delete associated user
        if ($student->user) {
            $student->user->delete();
        }
        
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}

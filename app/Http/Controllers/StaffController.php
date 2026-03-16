<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|string|unique:staff,staff_id',
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'national_id' => 'required|string|unique:staff,national_id',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'qualification' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'hire_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create staff record
        $staff = Staff::create([
            'user_id' => $user->id,
            'staff_id' => $validated['staff_id'],
            'department_id' => $validated['department_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'position' => $validated['position'],
            'employment_type' => $validated['employment_type'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'national_id' => $validated['national_id'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'specialization' => $validated['specialization'],
            'hire_date' => $validated['hire_date'],
            'basic_salary' => $validated['basic_salary'],
            'bank_name' => $validated['bank_name'],
            'bank_account' => $validated['bank_account'],
            'tax_id' => $validated['tax_id'],
            'status' => 'active',
        ]);

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load(['department', 'user', 'contracts', 'leaveRequests', 'payrolls']);
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::all();
        return view('staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'national_id' => ['required', 'string', Rule::unique('staff')->ignore($staff->id)],
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'qualification' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,terminated',
        ]);

        $staff->update($validated);

        // Update user name if changed
        if ($staff->user) {
            $staff->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name']
            ]);
        }

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        // Delete associated user
        if ($staff->user) {
            $staff->user->delete();
        }
        
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }
}

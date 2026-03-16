@extends('layouts.qbo')

@section('title', 'Student Details')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-graduate mr-2"></i>
            Student Details
        </h1>
        <p class="text-gray-600 mt-2">View and manage student information and records.</p>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Profile Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-20 w-20 rounded-full" src="https://picsum.photos/seed/{{ $student->id }}/100/100.jpg" alt="">
                            <div class="ml-6">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $student->full_name }}</h1>
                                <p class="text-gray-600">Student ID: {{ $student->student_id }}</p>
                                <p class="text-gray-600">{{ $student->program->name ?? 'No Program' }}</p>
                                <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $student->status == 'active' ? 'bg-green-100 text-green-800' : 
                                       ($student->status == 'inactive' ? 'bg-gray-100 text-gray-800' : 
                                       ($student->status == 'graduated' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('students.edit', $student) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button class="tab-btn py-2 px-6 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="personal">
                            Personal Info
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="academic">
                            Academic
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="financial">
                            Financial
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="lms">
                            LMS
                        </button>
                        <button class="tab-btn py-2 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="attendance">
                            Attendance
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Personal Information Tab -->
                    <div id="personal-tab" class="tab-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->date_of_birth->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Gender:</dt>
                                        <dd class="text-sm text-gray-900">{{ ucfirst($student->gender) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Nationality:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->nationality }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">National ID:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->national_id }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Email:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->user->email ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Phone:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->phone }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Address:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->address }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">City:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->city }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Contact Name:</dt>
                                    <dd class="text-sm text-gray-900">{{ $student->emergency_contact_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Contact Phone:</dt>
                                    <dd class="text-sm text-gray-900">{{ $student->emergency_contact_phone }}</dd>
                                </div>
                            </dl>
                        </div>

                        @if($student->medical_notes)
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Medical Notes</h3>
                                <p class="text-sm text-gray-700">{{ $student->medical_notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Academic Tab -->
                    <div id="academic-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Academic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Program:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->program->name ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Admission Date:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->admission_date->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Expected Graduation:</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->expected_graduation?->format('M d, Y') ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Current Enrollments</h4>
                                @if($student->enrollments->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($student->enrollments as $enrollment)
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ $enrollment->course->name ?? 'Course' }}</p>
                                                <p class="text-xs text-gray-500">Status: {{ ucfirst($enrollment->status ?? 'active') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No current enrollments</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Recent Grades</h4>
                            @if($student->grades->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($student->grades->take(5) as $grade)
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $grade->course->name ?? 'Course' }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $grade->grade }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $grade->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No grades recorded yet</p>
                            @endif
                        </div>
                    </div>

                    <!-- Financial Tab -->
                    <div id="financial-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Fee Structure</h4>
                                @if($student->fees->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($student->fees as $fee)
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ $fee->fee_structure->name ?? 'Fee' }}</p>
                                                <p class="text-xs text-gray-500">Amount: {{ number_format($fee->amount, 2) }}</p>
                                                <p class="text-xs text-gray-500">Status: {{ ucfirst($fee->status ?? 'pending') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No fee records found</p>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Payment History</h4>
                                @if($student->feePayments->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($student->feePayments as $payment)
                                            <div class="bg-green-50 p-3 rounded-lg">
                                                <p class="text-sm font-medium text-gray-900">{{ number_format($payment->amount, 2) }}</p>
                                                <p class="text-xs text-gray-500">Date: {{ $payment->payment_date->format('M d, Y') }}</p>
                                                <p class="text-xs text-gray-500">Method: {{ ucfirst($payment->payment_method ?? 'cash') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No payment records found</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- LMS Tab -->
                    <div id="lms-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">LMS Access</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Registration Status</h4>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $student->registration_status ?? 'accepted_pending_payment')) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Completed At</span>
                                        <span class="text-sm text-gray-900">{{ $student->registration_completed_at?->format('M d, Y H:i') ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">LMS courses are auto-enrolled when status becomes Registered.</p>
                            </div>

                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Add LMS Course</h4>
                                @if(($student->registration_status ?? null) !== 'registered')
                                    <p class="text-sm text-gray-500">Student is not registered yet. Complete fee requirements to enable LMS auto-enrollment.</p>
                                @else
                                    <form action="{{ route('students.lms-enrollments.store', $student) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label for="lms_course_id" class="block text-sm font-medium text-gray-700">LMS Course</label>
                                            <select id="lms_course_id" name="lms_course_id" required
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="">Select a course</option>
                                                @foreach($availableLmsCourses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                Add
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Current LMS Enrollments</h4>

                            @if($lmsEnrollments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Completed</th>
                                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($lmsEnrollments as $enrollment)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $enrollment->course->title ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ number_format($enrollment->progress ?? 0, 0) }}%</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $enrollment->completed_at ? 'Yes' : 'No' }}</td>
                                                    <td class="px-4 py-2 text-sm text-right">
                                                        <form action="{{ route('students.lms-enrollments.destroy', [$student, $enrollment]) }}" method="POST" class="inline" onsubmit="return confirm('Remove this LMS enrollment?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No LMS enrollments found.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance Tab -->
                    <div id="attendance-tab" class="tab-content hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Attendance Records</h3>
                        @if($student->attendances->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($student->attendances->take(10) as $attendance)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $attendance->date->format('M d, Y') }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $attendance->course->name ?? 'Course' }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $attendance->notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No attendance records found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Remove active state from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    // Show selected tab content
                    document.getElementById(tabName + '-tab').classList.remove('hidden');
                    
                    // Add active state to clicked button
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-blue-500', 'text-blue-600');
                });
            });
        });
    </script>
@endsection

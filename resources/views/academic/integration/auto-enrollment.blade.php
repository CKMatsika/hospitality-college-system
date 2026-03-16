@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-robot mr-3"></i>
                Auto-Enrollment Management
            </h1>
            <p class="text-gray-600 mt-2">Intelligent course enrollment based on academic programs and requirements</p>
        </div>

        <!-- Auto-Enrollment Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Student::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">With Programs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Student::whereNotNull('program_id')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Enrolled</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Student::whereHas('enrollments')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Need Enrollment</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Student::whereDoesntHave('enrollments')->whereNotNull('program_id')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-Enrollment Rules -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-cogs mr-2"></i>
                    Auto-Enrollment Rules
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-book mr-2 text-blue-500"></i>
                            Program-Based Enrollment
                        </h4>
                        <p class="text-xs text-gray-600">Automatically enroll students in all required courses for their academic program</p>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-sort-amount-up mr-2 text-green-500"></i>
                            Prerequisite Check
                        </h4>
                        <p class="text-xs text-gray-600">Verify course prerequisites before automatic enrollment</p>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-clock mr-2 text-purple-500"></i>
                            Semester-Based
                        </h4>
                        <p class="text-xs text-gray-600">Enroll students based on current semester and academic year</p>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-user-graduate mr-2 text-yellow-500"></i>
                            Year Level
                        </h4>
                        <p class="text-xs text-gray-600">Match courses to student's year of study</p>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-chart-line mr-2 text-red-500"></i>
                            Performance-Based
                        </h4>
                        <p class="text-xs text-gray-600">Consider academic performance for course placement</p>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-shield-alt mr-2 text-indigo-500"></i>
                            Capacity Limits
                        </h4>
                        <p class="text-xs text-gray-600">Respect maximum class sizes and waitlists</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Enrollments -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-user-clock mr-2"></i>
                        Students Requiring Auto-Enrollment
                    </h3>
                    <form action="{{ route('academic-integration.auto-enrollment.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                            <i class="fas fa-play mr-2"></i>
                            Process Auto-Enrollment
                        </button>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Program
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Year Level
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Required Courses
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $studentsNeedingEnrollment = App\Models\Student::whereDoesntHave('enrollments')
                                    ->whereNotNull('program_id')
                                    ->with('program')
                                    ->limit(10)
                                    ->get();
                            @endphp
                            
                            @forelse($studentsNeedingEnrollment as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->student_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->program->name ?? 'No Program' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $student->year_level ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $requiredCourses = $student->program ? 
                                                App\Models\Course::where('program_id', $student->program_id)->count() : 0;
                                        @endphp
                                        {{ $requiredCourses }} courses
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900" onclick="enrollStudent({{ $student->id }})">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            Enroll Now
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">All students are enrolled!</p>
                                        <p class="text-gray-400 text-sm mt-2">No students require auto-enrollment at this time</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Enrollment History -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-history mr-2"></i>
                    Recent Auto-Enrollments
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Batch enrollment completed</p>
                                <p class="text-xs text-gray-500">15 students enrolled in 45 courses</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">2 hours ago</p>
                            <p class="text-xs text-green-600">Successful</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-robot text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Scheduled auto-enrollment</p>
                                <p class="text-xs text-gray-500">8 students processed for Fall semester</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">1 day ago</p>
                            <p class="text-xs text-blue-600">Automatic</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Partial enrollment completed</p>
                                <p class="text-xs text-gray-500">3 students had prerequisite issues</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">2 days ago</p>
                            <p class="text-xs text-yellow-600">Warning</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-sliders-h mr-2"></i>
                    Auto-Enrollment Configuration
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Enrollment Settings</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Enable Auto-Enrollment</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Check Prerequisites</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Respect Capacity Limits</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-700">Send Notifications</label>
                                <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Schedule</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-700">Run Frequency</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                    <option>Manual Only</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm text-gray-700">Preferred Time</label>
                                <input type="time" value="02:00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-sm text-gray-700">Next Run</label>
                                <input type="text" value="Tomorrow, 2:00 AM" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-500">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>
                        Save Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function enrollStudent(studentId) {
    if (confirm('Are you sure you want to enroll this student in all required courses?')) {
        // Implement individual student enrollment
        window.location.href = `/academic-integration/enroll-student/${studentId}`;
    }
}
</script>
@endsection

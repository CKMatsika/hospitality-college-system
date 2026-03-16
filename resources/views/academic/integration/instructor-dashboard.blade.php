@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chart-line mr-3"></i>
                Academic Integration Dashboard
            </h1>
            <p class="text-gray-600 mt-2">Comprehensive overview of academic performance and integration metrics</p>
        </div>

        <!-- Key Metrics Overview -->
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
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Courses</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Course::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Enrollments</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Enrollment::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Certificates</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ App\Models\Certificate::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Academic Performance -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-university mr-2"></i>
                        Academic Performance
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Average GPA</span>
                            <span class="text-sm font-medium">3.2</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Completion Rate</span>
                            <span class="text-sm font-medium">87%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Students</span>
                            <span class="text-sm font-medium">{{ App\Models\Student::where('status', 'active')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Course Completion</span>
                            <span class="text-sm font-medium">92%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LMS Integration -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-laptop mr-2"></i>
                        LMS Integration
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">LMS Enrollments</span>
                            <span class="text-sm font-medium">{{ App\Models\LmsEnrollment::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Average Progress</span>
                            <span class="text-sm font-medium">76%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Completed Courses</span>
                            <span class="text-sm font-medium">{{ App\Models\LmsEnrollment::whereNotNull('completed_at')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Learners</span>
                            <span class="text-sm font-medium">{{ App\Models\LmsEnrollment::whereNull('completed_at')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Online Learning Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Exams -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Online Exams
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Exams</span>
                            <span class="text-sm font-medium">{{ App\Models\OnlineExam::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Submissions</span>
                            <span class="text-sm font-medium">{{ App\Models\ExamSubmission::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Average Score</span>
                            <span class="text-sm font-medium">78%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pass Rate</span>
                            <span class="text-sm font-medium">85%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lessons -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-book-open mr-2"></i>
                        Online Lessons
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Lessons</span>
                            <span class="text-sm font-medium">{{ App\Models\OnlineLesson::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Enrollments</span>
                            <span class="text-sm font-medium">{{ App\Models\LessonEnrollment::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Completed</span>
                            <span class="text-sm font-medium">{{ App\Models\LessonEnrollment::where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">In Progress</span>
                            <span class="text-sm font-medium">{{ App\Models\LessonEnrollment::where('status', 'in_progress')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-tasks mr-2"></i>
                        Online Assignments
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Assignments</span>
                            <span class="text-sm font-medium">{{ App\Models\OnlineAssignment::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Submissions</span>
                            <span class="text-sm font-medium">{{ App\Models\AssignmentSubmission::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Graded</span>
                            <span class="text-sm font-medium">{{ App\Models\AssignmentSubmission::whereNotNull('graded_at')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pending</span>
                            <span class="text-sm font-medium">{{ App\Models\AssignmentSubmission::whereNull('graded_at')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CPD Overview -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-award mr-2"></i>
                    CPD Overview
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ App\Models\CpdRecord::count() }}</div>
                        <div class="text-sm text-gray-500">Total CPD Records</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ App\Models\CpdRecord::where('status', 'approved')->count() }}</div>
                        <div class="text-sm text-gray-500">Approved Records</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ App\Models\CpdRecord::where('status', 'pending')->count() }}</div>
                        <div class="text-sm text-gray-500">Pending Approval</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ App\Models\Certificate::where('type', 'cpd_certificate')->count() }}</div>
                        <div class="text-sm text-gray-500">CPD Certificates</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-bolt mr-2"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('academic-integration.auto-enrollment') }}" class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                        <i class="fas fa-robot mr-2"></i>
                        Auto-Enrollment
                    </a>
                    <a href="{{ route('academic-integration.analytics') }}" class="inline-flex items-center justify-center px-4 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-purple-700">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Analytics
                    </a>
                    <a href="{{ route('cpd.admin.index') }}" class="inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-700">
                        <i class="fas fa-award mr-2"></i>
                        CPD Admin
                    </a>
                    <a href="{{ route('students.index') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-gray-700">
                        <i class="fas fa-users mr-2"></i>
                        Students
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

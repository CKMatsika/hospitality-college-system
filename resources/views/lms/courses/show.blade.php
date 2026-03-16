<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Online Course Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h1>
                            <p class="text-gray-600">Code: {{ $course->course_code }}</p>
                            <p class="text-gray-600">{{ $course->instructor->full_name ?? 'No Instructor' }}</p>
                            <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('lms.courses.edit', $course) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('lms.courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Course Information</h3>
                        </div>
                        <div class="p-6">
                            @if($course->description)
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                                    <p class="text-gray-700">{{ $course->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Course Code</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->course_code }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Instructor</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->instructor->full_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->duration_weeks }} weeks</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Level</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($course->difficulty_level) }}</p>
                                </div>
                            </div>

                            @if($course->prerequisites)
                                <div class="mt-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-2">Prerequisites</h4>
                                    <p class="text-gray-700">{{ $course->prerequisites }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Modules -->
                    <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Course Modules</h3>
                                <span class="text-sm text-gray-500">{{ $course->modules->count() }} modules</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($course->modules->count() > 0)
                                <div class="space-y-4">
                                    @foreach($course->modules as $module)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $module->title }}</h4>
                                                    <p class="text-sm text-gray-500">Order: {{ $module->order }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $module->lessons->count() }} lessons
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No modules created yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Enrollments -->
                    <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Student Enrollments</h3>
                                <span class="text-sm text-gray-500">{{ $course->enrollments->count() }} students enrolled</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($course->enrollments->count() > 0)
                                <div class="space-y-3">
                                    @foreach($course->enrollments as $enrollment)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $enrollment->student->full_name }}</h4>
                                                    <p class="text-sm text-gray-500">ID: {{ $enrollment->student->student_id }}</p>
                                                    <p class="text-sm text-gray-500">Enrolled: {{ $enrollment->enrollment_date->format('M d, Y') }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $enrollment->status == 'active' ? 'bg-green-100 text-green-800' : 
                                                       ($enrollment->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($enrollment->status) }}
                                                </span>
                                                <div class="text-sm text-gray-500">
                                                    Progress: {{ $enrollment->progress_percentage }}%
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No enrollments yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Statistics -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-red-600">{{ $course->enrollments->count() }}</div>
                                    <div class="text-sm text-gray-500">Total Enrollments</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-600">{{ $course->modules->count() }}</div>
                                    <div class="text-sm text-gray-500">Modules</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600">{{ $course->duration_weeks }}</div>
                                    <div class="text-sm text-gray-500">Weeks Duration</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('lms.courses.edit', $course) }}" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Edit Course
                                </a>
                                <a href="{{ route('lms.courses.modules.create', $course) }}" class="block w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-plus mr-2"></i> Add Module
                                </a>
                                <a href="{{ route('lms.enrollments.create') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-user-plus mr-2"></i> Enroll Student
                                </a>
                                <a href="{{ route('lms.courses.index') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-list mr-2"></i> All Courses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $course->name }}</h1>
                            <p class="text-gray-600">Code: {{ $course->code }}</p>
                            <p class="text-gray-600">{{ $course->program->name ?? 'No Program' }}</p>
                            <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('courses.edit', $course) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
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
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->code }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Credits</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->credits }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->duration_hours }} hours</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Program</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $course->program->name ?? 'N/A' }}</p>
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
                                                    {{ $enrollment->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($enrollment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No students enrolled yet.</p>
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
                                    <div class="text-3xl font-bold text-purple-600">{{ $course->enrollments->count() }}</div>
                                    <div class="text-sm text-gray-500">Total Enrollments</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600">{{ $course->credits }}</div>
                                    <div class="text-sm text-gray-500">Credits</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600">{{ $course->duration_hours }}</div>
                                    <div class="text-sm text-gray-500">Duration (Hours)</div>
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
                                <a href="{{ route('courses.edit', $course) }}" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Edit Course
                                </a>
                                <a href="{{ route('courses.index') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors">
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

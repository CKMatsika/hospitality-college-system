<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Program Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $program->name }}</h1>
                            <p class="text-gray-600">Code: {{ $program->code }}</p>
                            <p class="text-gray-600">{{ $program->department->name ?? 'No Department' }}</p>
                            <span class="mt-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $program->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('programs.edit', $program) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('programs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Program Information</h3>
                        </div>
                        <div class="p-6">
                            @if($program->description)
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                                    <p class="text-gray-700">{{ $program->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $program->duration_years }} {{ $program->duration_years == 1 ? 'Year' : 'Years' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Credits Required</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $program->credits_required }} Credits</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Tuition Fee</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ number_format($program->tuition_fee, 2) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Department</h4>
                                    <p class="text-lg font-semibold text-gray-900">{{ $program->department->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Courses -->
                    <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Courses</h3>
                                <a href="{{ route('courses.create', ['program_id' => $program->id]) }}" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                                    <i class="fas fa-plus mr-1"></i> Add Course
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($program->courses->count() > 0)
                                <div class="space-y-3">
                                    @foreach($program->courses as $course)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $course->name }}</h4>
                                                    <p class="text-sm text-gray-600">Code: {{ $course->code }}</p>
                                                    <p class="text-sm text-gray-600">Credits: {{ $course->credits }} | Duration: {{ $course->duration_hours }} hours</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($course->status) }}
                                                </span>
                                            </div>
                                            @if($course->description)
                                                <p class="text-sm text-gray-700 mt-2">{{ $course->description }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No courses added to this program yet.</p>
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
                                    <div class="text-3xl font-bold text-blue-600">{{ $program->students->count() ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Total Students</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600">{{ $program->courses->count() ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Total Courses</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-yellow-600">{{ $program->credits_required }}</div>
                                    <div class="text-sm text-gray-500">Credits Required</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Students -->
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Recent Students</h3>
                        </div>
                        <div class="p-6">
                            @if($program->students->count() > 0)
                                <div class="space-y-3">
                                    @foreach($program->students->take(5) as $student)
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full" src="https://picsum.photos/seed/{{ $student->id }}/50/50.jpg" alt="">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                                <p class="text-xs text-gray-500">ID: {{ $student->student_id }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($program->students->count() > 5)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('students.index', ['program' => $program->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View All Students
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-gray-500">No students enrolled yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

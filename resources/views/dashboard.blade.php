@extends('layouts.qbo-main')

@section('title', 'Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Hospitality College Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}! Here's your complete system overview.</p>
    </div>
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Students</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Staff</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_staff'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Programs Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Programs</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_programs'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Students -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Students</h3>
                    </div>
                    <div class="p-6">
                        @if($recentStudents->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentStudents as $student)
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $student->id }}/50/50.jpg" alt="">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $student->program->name ?? 'No Program' }} • ID: {{ $student->student_id }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No students registered yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Staff -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Staff</h3>
                    </div>
                    <div class="p-6">
                        @if($recentStaff->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentStaff as $staff)
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="https://picsum.photos/seed/{{ $staff->id }}/50/50.jpg" alt="">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $staff->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $staff->position }} • {{ $staff->department->name ?? 'No Department' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No staff registered yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    <p class="text-sm text-gray-500">Access all system features from the navigation menu above</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('students.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Student
                        </a>
                        <a href="{{ route('staff.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Staff
                        </a>
                        <a href="{{ route('courses.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Course
                        </a>
                        <a href="{{ route('programs.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Program
                        </a>
                        @if(Auth::user()->role === 'super_admin')
                            <a href="{{ route('system-settings.edit') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-cog mr-2"></i> System Settings
                            </a>
                        @endif
                    </div>
                </div>
            </div>
@endsection

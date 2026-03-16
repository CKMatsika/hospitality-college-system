@extends('layouts.qbo')

@section('title', 'LMS Dashboard')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-laptop mr-2"></i>
            Learning Management System
        </h1>
        <p class="text-gray-600 mt-2">Manage online courses, enrollments, and student learning progress.</p>
    </div>

    <!-- LMS Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Courses" 
            value="{{ $stats['total_courses'] }}" 
            icon="fas fa-graduation-cap" 
            color="purple"
            trend="stable"
            trendValue="Available courses"
        />
        <x-stat-card 
            title="Active Courses" 
            value="{{ $stats['active_courses'] }}" 
            icon="fas fa-play-circle" 
            color="green"
            trend="up"
            trendValue="Currently running"
        />
        <x-stat-card 
            title="Total Enrollments" 
            value="{{ $stats['total_enrollments'] }}" 
            icon="fas fa-users" 
            color="blue"
            trend="up"
            trendValue="Student enrollments"
        />
        <x-stat-card 
            title="Completed" 
            value="{{ $stats['completed_enrollments'] }}" 
            icon="fas fa-trophy" 
            color="yellow"
            trend="up"
            trendValue="Course completions"
        />
    </div>

    <!-- Recent Courses -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Courses</h2>
            <a href="{{ route('lms.courses.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        @if($recentCourses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentCourses as $course)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-900">{{ $course->title }}</h4>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($course->description, 100) }}</p>
                        <div class="flex justify-between text-sm text-gray-500 mb-3">
                            <span><i class="fas fa-clock mr-1"></i>{{ $course->duration_weeks }} weeks</span>
                            <span><i class="fas fa-signal mr-1"></i>{{ ucfirst($course->difficulty_level) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-user mr-1"></i>{{ $course->enrollments->count() }} enrolled
                            </span>
                            <a href="{{ route('lms.courses.show', $course) }}" 
                               class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                View Course
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-graduation-cap text-4xl mb-4"></i>
                <p>No courses created yet.</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('lms.courses.create') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Course
            </a>
            <a href="{{ route('lms.enrollments.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-plus mr-2"></i> Enroll Student
            </a>
            <a href="{{ route('lms.courses.index') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i> Manage Courses
            </a>
            <a href="{{ route('lms.student.courses') }}" class="flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-user-graduate mr-2"></i> Student Portal
            </a>
        </div>
    </div>

@endsection

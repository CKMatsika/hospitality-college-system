@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-graduation-cap mr-3"></i>
                Online Learning Dashboard
            </h1>
            <p class="text-gray-600 mt-2">Manage exams, lessons, assignments, and certificates</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Exams</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalExams }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-play-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Lessons</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $activeLessons }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Assignments</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $pendingAssignments }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Certificates Issued</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalCertificates }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('exams.create') }}" class="block w-full text-left px-4 py-3 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100">
                            <i class="fas fa-graduation-cap mr-3"></i>
                            Create New Exam
                        </a>
                        <a href="{{ route('lessons.create') }}" class="block w-full text-left px-4 py-3 bg-green-50 text-green-700 rounded-md hover:bg-green-100">
                            <i class="fas fa-play-circle mr-3"></i>
                            Create New Lesson
                        </a>
                        <a href="{{ route('assignments.create') }}" class="block w-full text-left px-4 py-3 bg-yellow-50 text-yellow-700 rounded-md hover:bg-yellow-100">
                            <i class="fas fa-tasks mr-3"></i>
                            Create New Assignment
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-line mr-2"></i>
                        Recent Activity
                    </h3>
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center">
                                    <i class="{{ $activity['icon'] }} {{ $activity['color'] }} mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['description'] }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $activity['time'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Exams -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Recent Exams
                        </h3>
                        <a href="{{ route('exams.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            View All
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentExams as $exam)
                            <div class="p-3 bg-gray-50 rounded-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $exam->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $exam->course->name }}</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $exam->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $exam->submissions->count() }} submissions
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Lessons -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-play-circle mr-2"></i>
                            Recent Lessons
                        </h3>
                        <a href="{{ route('lessons.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            View All
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentLessons as $lesson)
                            <div class="p-3 bg-gray-50 rounded-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $lesson->course->name }}</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $lesson->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $lesson->enrollments->count() }} enrolled
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Assignments -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-tasks mr-2"></i>
                            Recent Assignments
                        </h3>
                        <a href="{{ route('assignments.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            View All
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentAssignments as $assignment)
                            <div class="p-3 bg-gray-50 rounded-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $assignment->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $assignment->course->name }}</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $assignment->isOverdue() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $assignment->submissions->count() }} submissions
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

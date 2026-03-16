@extends('layouts.qbo')

@section('title', 'Online Lessons')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-play-circle mr-2"></i>
            Online Lessons
        </h1>
        <p class="text-gray-600 mt-2">Create and manage interactive online lessons for your students.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Lessons" 
            value="{{ $lessons->count() }}" 
            icon="fas fa-play-circle" 
            color="blue"
            trend="up"
            trendValue="All lessons"
        />
        <x-stat-card 
            title="Published" 
            value="{{ $lessons->where('is_published', true)->count() }}" 
            icon="fas fa-check-circle" 
            color="green"
            trend="up"
            trendValue="Live lessons"
        />
        <x-stat-card 
            title="Drafts" 
            value="{{ $lessons->where('is_published', false)->count() }}" 
            icon="fas fa-edit" 
            color="yellow"
            trend="stable"
            trendValue="In progress"
        />
        <x-stat-card 
            title="Total Students" 
            value="{{ $lessons->sum('enrollments_count') }}" 
            icon="fas fa-users" 
            color="purple"
            trend="up"
            trendValue="Enrolled students"
        />
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('online-learning.lessons.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Lesson
            </a>
            <a href="{{ route('online-learning.exams.index') }}" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i> Manage Exams
            </a>
            <a href="{{ route('online-learning.assignments.index') }}" class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-tasks mr-2"></i> View Assignments
            </a>
        </div>
    </div>

    <!-- Lessons List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Lessons List</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Duration
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Enrollments
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($lessons as $lesson)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $lesson->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $lesson->course->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $lesson->lesson_type === 'video' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $lesson->lesson_type === 'text' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $lesson->lesson_type === 'interactive' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $lesson->lesson_type === 'live_session' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $lesson->lesson_type === 'assignment' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $lesson->lesson_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $lesson->duration_minutes ? $lesson->duration_minutes . ' min' : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $lesson->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $lesson->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $lesson->enrollments->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($lesson->is_published)
                                                <a href="{{ route('online-learning.lessons.show', $lesson) }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </a>
                                                
                                                @if($lesson->isLive())
                                                    <a href="{{ route('online-learning.lessons.student-view', $lesson) }}" class="text-green-600 hover:text-green-900">
                                                        <i class="fas fa-play mr-1"></i>
                                                        Join Live
                                                    </a>
                                                @endif
                                            @endif
                                            
                                            <a href="{{ route('online-learning.lessons.edit', $lesson) }}" class="text-gray-600 hover:text-gray-900">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($lessons->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No lessons found</p>
                        <p class="text-gray-400 text-sm mt-2">Get started by creating your first online lesson</p>
                        <div class="mt-4">
                            <a href="{{ route('online-learning.lessons.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>
                                Create Your First Lesson
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

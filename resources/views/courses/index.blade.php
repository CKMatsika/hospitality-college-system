@extends('layouts.qbo')

@section('title', 'Courses')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-book mr-2"></i>
            Courses
        </h1>
        <p class="text-gray-600 mt-2">Manage course offerings and curriculum.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Courses</h3>
                        <a href="{{ route('courses.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add New Course
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('courses.index') }}" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <select name="program" class="rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">All Programs</option>
                                @foreach($programs ?? [] as $program)
                                    <option value="{{ $program->id }}" {{ request('program') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                    </div>

                    <!-- Courses Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($courses as $course)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $course->name }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Code:</span> {{ $course->code }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Program:</span> {{ $course->program->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Credits:</span> {{ $course->credits }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Duration:</span> {{ $course->duration_hours }} hours
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Enrolled:</span> {{ $course->enrollments->count() ?? 0 }} students
                                        </p>
                                    </div>
                                    
                                    @if($course->description)
                                        <p class="text-sm text-gray-700 mb-4 line-clamp-3">{{ $course->description }}</p>
                                    @endif
                                    
                                    @if($course->prerequisites)
                                        <div class="mb-4">
                                            <p class="text-xs text-gray-500">
                                                <span class="font-medium">Prerequisites:</span> {{ $course->prerequisites }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between">
                                        <a href="{{ route('courses.show', $course) }}" 
                                           class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                            View Details
                                        </a>
                                        <div class="space-x-2">
                                            <a href="{{ route('courses.edit', $course) }}" 
                                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">No courses found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($courses->hasPages())
                        <div class="mt-8">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

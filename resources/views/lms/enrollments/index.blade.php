@extends('layouts.qbo')

@section('title', 'LMS Enrollments')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-graduate mr-2"></i>
            Course Enrollments
        </h1>
        <p class="text-gray-600 mt-2">Manage student enrollments in Learning Management System courses.</p>
    </div>
            <!-- Enrollment Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Enrollments" 
            value="{{ $stats['total_enrollments'] }}" 
            icon="fas fa-users" 
            color="purple"
            trend="up"
            trendValue="All time"
        />
        <x-stat-card 
            title="Active Enrollments" 
            value="{{ $stats['active_enrollments'] }}" 
            icon="fas fa-user-check" 
            color="green"
            trend="up"
            trendValue="Currently active"
        />
        <x-stat-card 
            title="Pending Enrollments" 
            value="{{ $stats['pending_enrollments'] }}" 
            icon="fas fa-clock" 
            color="yellow"
            trend="stable"
            trendValue="Awaiting approval"
        />
        <x-stat-card 
            title="Completed" 
            value="{{ $stats['completed_enrollments'] }}" 
            icon="fas fa-graduation-cap" 
            color="blue"
            trend="up"
            trendValue="Successfully completed"
        />
    </div>

            <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('lms.enrollments.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Student name, course, or email"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" 
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                </select>
                            </div>
                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                                <select id="course_id" name="course_id" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">All Courses</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-search mr-2"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enrollments Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Enrollment Records</h3>
                        <a href="{{ route('lms.enrollments.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> New Enrollment
                        </a>
                    </div>

                    @if($enrollments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($enrollments as $enrollment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                            <span class="text-purple-600 font-medium text-sm">
                                                                {{ substr($enrollment->student->full_name ?? 'N/A', 0, 1) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $enrollment->student->full_name ?? 'N/A' }}</div>
                                                        <div class="text-sm text-gray-500">{{ $enrollment->student->email ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $enrollment->course->title ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $enrollment->course->course_code ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $enrollment->course->instructor->full_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($enrollment->status)
                                                    @case('active')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                        @break
                                                    @case('pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Completed
                                                        </span>
                                                        @break
                                                    @case('dropped')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Dropped
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ $enrollment->status }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm text-gray-900">{{ $enrollment->progress ?? 0 }}%</div>
                                                    <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('lms.enrollments.show', $enrollment->id) }}" 
                                                       class="text-purple-600 hover:text-purple-900">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('lms.enrollments.edit', $enrollment->id) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('lms.enrollments.destroy', $enrollment->id) }}" 
                                                          onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $enrollments->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 mb-4">
                                <i class="fas fa-user-graduate text-6xl mb-4"></i>
                                <p class="text-lg">No enrollments found</p>
                                <p class="text-sm">Get started by creating your first enrollment.</p>
                            </div>
                            <a href="{{ route('lms.enrollments.create') }}" 
                               class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i> Create Enrollment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

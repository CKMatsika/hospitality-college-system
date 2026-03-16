@extends('layouts.qbo')

@section('title', 'Academic Programs')

@section('content')
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-graduation-cap mr-2"></i>
            Academic Programs
        </h1>
        <p class="text-gray-600 mt-2">Manage academic programs and degree offerings.</p>
    </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Programs</h3>
                        <a href="{{ route('programs.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add New Program
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('programs.index') }}" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search programs..." value="{{ request('search') }}" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            <select name="department" class="rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                <option value="">All Departments</option>
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                    </div>

                    <!-- Programs Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($programs as $program)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $program->name }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $program->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($program->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Code:</span> {{ $program->code }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Department:</span> {{ $program->department->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Duration:</span> {{ $program->duration_years }} years
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Credits:</span> {{ $program->credits_required }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Tuition:</span> {{ number_format($program->tuition_fee, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Students:</span> {{ $program->students->count() ?? 0 }}
                                        </p>
                                    </div>
                                    
                                    @if($program->description)
                                        <p class="text-sm text-gray-700 mb-4 line-clamp-3">{{ $program->description }}</p>
                                    @endif
                                    
                                    <div class="flex justify-between">
                                        <a href="{{ route('programs.show', $program) }}" 
                                           class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                                            View Details
                                        </a>
                                        <div class="space-x-2">
                                            <a href="{{ route('programs.edit', $program) }}" 
                                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
                                <p class="text-gray-500">No programs found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($programs->hasPages())
                        <div class="mt-8">
                            {{ $programs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Create New Exam
                    </h1>
                    <a href="{{ route('exams.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Exams
                    </a>
                </div>

                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Exam Title *</label>
                                <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                            </div>
                            
                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700">Course *</label>
                                <select id="course_id" name="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Date & Time *</label>
                                <input type="datetime-local" id="start_time" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">End Date & Time *</label>
                                <input type="datetime-local" id="end_time" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration (minutes) *</label>
                                <input type="number" id="duration_minutes" name="duration_minutes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="60" required>
                            </div>
                            
                            <div>
                                <label for="passing_score" class="block text-sm font-medium text-gray-700">Passing Score (%) *</label>
                                <input type="number" id="passing_score" name="passing_score" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" max="100" step="0.01" value="50.00" required>
                            </div>
                            
                            <div>
                                <label for="total_marks" class="block text-sm font-medium text-gray-700">Total Marks *</label>
                                <input type="number" id="total_marks" name="total_marks" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="100.00" required>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="allow_multiple_attempts" name="allow_multiple_attempts" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="allow_multiple_attempts" class="ml-2 block text-sm font-medium text-gray-700">Allow Multiple Attempts</label>
                            </div>
                            
                            @if(old('allow_multiple_attempts'))
                                <div>
                                    <label for="max_attempts" class="block text-sm font-medium text-gray-700">Maximum Attempts</label>
                                    <input type="number" id="max_attempts" name="max_attempts" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="{{ old('max_attempts', 1) }}" required>
                                </div>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="require_proctoring" name="require_proctoring" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="require_proctoring" class="ml-2 block text-sm font-medium text-gray-700">Require Proctoring</label>
                            </div>
                            
                            @if(old('require_proctoring'))
                                <div>
                                    <label for="proctoring_instructions" class="block text-sm font-medium text-gray-700">Proctoring Instructions</label>
                                    <textarea id="proctoring_instructions" name="proctoring_instructions" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('proctoring_instructions') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Instructions for students during the exam (e.g., no external resources, camera required, etc.)</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('exams.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Create Exam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

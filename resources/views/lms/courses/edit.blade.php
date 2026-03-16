<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Online Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('lms.courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PATCH'
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $course->title) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="course_code" class="block text-sm font-medium text-gray-700">Course Code</label>
                                <input type="text" id="course_code" name="course_code" value="{{ old('course_code', $course->course_code) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                @error('course_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="instructor_id" class="block text-sm font-medium text-gray-700">Instructor</label>
                                <select id="instructor_id" name="instructor_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Select an instructor</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instructor_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="duration_weeks" class="block text-sm font-medium text-gray-700">Duration (Weeks)</label>
                                <input type="number" id="duration_weeks" name="duration_weeks" value="{{ old('duration_weeks', $course->duration_weeks) }}" min="1" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                @error('duration_weeks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @error('duration_weeks')
                            </div>
                            <div>
                                <label for="difficulty_level" class="block text-sm font-medium text-gray-700">Difficulty Level</label>
                                <select id="difficulty_level" name="difficulty_level" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Select difficulty level</option>
                                    <option value="beginner" {{ old('difficulty_level', $course->difficulty_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty_level', $course->difficulty_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty_level', $course->difficulty_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty_level')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @error('difficulty_level')
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="archived" {{ old('status', $course->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @error('status')
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Course Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old('description', $course->description) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Provide a comprehensive description of the course content and learning objectives.</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @error('description')
                        </div>

                        <div class="mt-6">
                            <label for="prerequisites" class="block text-sm font-medium text-gray-700">Prerequisites</label>
                            <input type="text" id="prerequisites" name="prerequisites" value="{{ old('prerequisites', $course->prerequisites) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                   placeholder="e.g., Basic Computer Skills, Introduction to Hospitality">
                            @error('prerequisites')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @error('prerequisites')
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('lms.courses.show', $course) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i> Update Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

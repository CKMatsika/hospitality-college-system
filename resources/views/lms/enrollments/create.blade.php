<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Enrollment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('lms.enrollments.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student *</label>
                                <select id="student_id" name="student_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Select a student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->full_name }} - {{ $student->student_id }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700">Course *</label>
                                <select id="course_id" name="course_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }} - {{ $course->course_code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="enrollment_date" class="block text-sm font-medium text-gray-700">Enrollment Date *</label>
                                <input type="date" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', now()->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                @error('enrollment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Enrollment Status</label>
                                <select id="status" name="status" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="dropped" {{ old('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Set initial status for this enrollment.</p>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="completion_date" class="block text-sm font-medium text-gray-700">Completion Date</label>
                                <input type="date" id="completion_date" name="completion_date" value="{{ old('completion_date') }}" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <p class="mt-1 text-sm text-gray-500">Only for completed enrollments.</p>
                                @error('completion_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                                <input type="text" id="grade" name="grade" value="{{ old('grade') }}" 
                                       placeholder="e.g., A, B+, 85%, Pass"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <p class="mt-1 text-sm text-gray-500">Final grade or assessment result.</p>
                                @error('grade')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="progress" class="block text-sm font-medium text-gray-700">Progress (%)</label>
                            <input type="number" id="progress" name="progress" value="{{ old('progress', 0) }}" min="0" max="100"
                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <p class="mt-1 text-sm text-gray-500">Current course completion percentage (0-100).</p>
                            @error('progress')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Enrollment Notes</label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Add any notes about this enrollment, special requirements, or accommodations.</p>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="send_notification" value="1" class="mr-2" checked>
                                <span class="text-sm font-medium text-gray-700">Send Enrollment Confirmation</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Send email notification to student about this enrollment.</p>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('lms.enrollments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-user-plus mr-2"></i> Create Enrollment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

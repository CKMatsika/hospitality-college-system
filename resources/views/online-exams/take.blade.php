@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Take Exam: {{ $exam->title }}
                    </h1>
                    <div class="text-sm text-gray-600">
                        Course: {{ $exam->course->name }} | Duration: {{ $exam->duration_minutes }} minutes
                    </div>
                </div>

                @if($submission)
                    <!-- Exam in Progress -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-lg font-medium text-blue-900">Exam in Progress</h3>
                                <p class="text-sm text-blue-700">
                                    Started: {{ $submission->start_time->format('M d, Y H:i:s') }}
                                </p>
                                <p class="text-sm text-blue-700">
                                    Time Remaining: <span id="timer">{{ $exam->duration_minutes * 60 - now()->diffInSeconds($submission->start_time) }}</span> seconds
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="examForm" action="{{ route('exams.submit', $exam) }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            @foreach($exam->questions as $index => $question)
                                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-medium text-gray-900">
                                                Question {{ $index + 1 }}: {{ $question->marks }} marks
                                            </h4>
                                            <p class="text-gray-700 mt-2">{{ $question->question_text }}</p>
                                            
                                            @if($question->isMultipleChoice())
                                                <div class="mt-4 space-y-2">
                                                    @foreach($question->options_array ?? [] as $optionIndex => $option)
                                                        <label class="flex items-center space-x-3">
                                                            <input type="radio" name="answers[{{ $question->id }}][answer]" value="{{ $optionIndex }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2">{{ $option }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            @if($question->isTrueFalse())
                                                <div class="mt-4 space-x-4">
                                                    <label class="flex items-center space-x-3">
                                                        <input type="radio" name="answers[{{ $question->id }}][answer]" value="true" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2">True</span>
                                                    </label>
                                                    <label class="flex items-center space-x-3">
                                                        <input type="radio" name="answers[{{ $question->id }}][answer]" value="false" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2">False</span>
                                                    </label>
                                                </div>
                                            @endif
                                            
                                            @if($question->isShortAnswer())
                                                <textarea name="answers[{{ $question->id }}][answer]" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3" placeholder="Type your answer here..."></textarea>
                                            @endif
                                            
                                            @if($question->isEssay())
                                                <textarea name="answers[{{ $question->id }}][answer]" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="5" placeholder="Write your essay here..."></textarea>
                                            @endif
                                        </div>
                                        
                                        <div class="text-sm text-gray-500">
                                            @if($question->explanation)
                                                <p class="mt-2"><em>Hint: {{ $question->explanation }}</em></p>
                                            @endif
                                        </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit Exam
                            </button>
                        </div>
                    </form>
                @else
                    <!-- Exam not started -->
                    <div class="text-center py-12">
                        <div class="mb-6 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-yellow-900">Exam Not Available</h3>
                            <p class="text-yellow-700">
                                This exam is not yet available. Please check back later.
                            </p>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('exams.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Exams
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Timer functionality
let timerInterval;
let timeRemaining = {{ $exam->duration_minutes * 60 }};

if (document.getElementById('timer')) {
    timerInterval = setInterval(function() {
        timeRemaining--;
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            document.getElementById('timer').textContent = 'Time\'s up!';
            document.getElementById('examForm').submit();
        } else {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            document.getElementById('timer').textContent = 
                minutes.toString().padStart(2, '0') + ':' + 
                seconds.toString().padStart(2, '0');
        }
    }, 1000);
}
</script>
@endsection

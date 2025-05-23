@extends('recruitment::candidate.layouts.app')

@section('title', 'Taking Quiz: ' . $assignment->quiz->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $assignment->quiz->name }}</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Duration: {{ $assignment->quiz->duration }} minutes</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form id="quizForm" action="{{ route('candidate.quiz.assignments.submit', $assignment->id) }}" method="POST">
                @csrf
                <div class="space-y-8">
                    @foreach($assignment->quiz->questions as $index => $question)
                        <div class="question-block" data-question-id="{{ $question->id }}">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Question {{ $index + 1 }}
                                </h3>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $question->text }}</p>
                            </div>

                            <div class="space-y-4">
                                @foreach($question->options as $option)
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $option->id }}" 
                                               id="option_{{ $option->id }}"
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                        <label for="option_{{ $option->id }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $option->text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span id="timeRemaining"></span>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" 
                                onclick="confirmSubmit()" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Timer functionality
    let timeLeft = {{ $assignment->quiz->duration * 60 }}; // Convert minutes to seconds
    const timerElement = document.getElementById('timeRemaining');
    
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `Time Remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            document.getElementById('quizForm').submit();
        } else {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
    }
    
    updateTimer();

    // Form submission confirmation
    function confirmSubmit() {
        const unansweredQuestions = document.querySelectorAll('.question-block').length - 
            document.querySelectorAll('input[type="radio"]:checked').length;
        
        if (unansweredQuestions > 0) {
            if (!confirm(`You have ${unansweredQuestions} unanswered questions. Are you sure you want to submit?`)) {
                return;
            }
        }
        
        document.getElementById('quizForm').submit();
    }

    // Prevent accidental navigation away
    window.onbeforeunload = function() {
        return "Are you sure you want to leave? Your progress will be lost.";
    };
</script>
@endpush
@endsection 
@extends('recruitment::candidate.layouts.app')

@section('title', 'Quiz Results: ' . $assignment->quiz->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz Results</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $assignment->quiz->name }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Score</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $assignment->score }}%</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Time Taken</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $assignment->completed_at->diffInMinutes($assignment->assigned_at) }} minutes
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                        <p class="mt-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($assignment->quiz->questions as $index => $question)
                    <div class="question-block border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                Question {{ $index + 1 }}
                            </h3>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $question->text }}</p>
                        </div>

                        <div class="space-y-4">
                            @foreach($question->options as $option)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($option->is_correct)
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        @elseif($assignment->answers->where('question_id', $question->id)->where('option_id', $option->id)->first())
                                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <label class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $option->text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if($question->explanation)
                            <div class="mt-4 bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    <span class="font-medium">Explanation:</span> {{ $question->explanation }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('candidate.quiz.assignments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to Assignments
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('recruitment::candidate.layouts.app')

@section('title', 'Quiz Assignment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz Assignment Details</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Quiz Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Quiz Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->quiz->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Duration</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->quiz->duration }} minutes</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Total Questions</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->quiz->questions_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Assignment Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <p class="mt-1">
                                @if($assignment->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($assignment->status === 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Expired
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Assigned At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Completed At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->completed_at ? $assignment->completed_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                        @if($assignment->score)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Score</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $assignment->score }}%</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($assignment->notes)
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Notes</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $assignment->notes }}</p>
                </div>
            </div>
            @endif

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('candidate.quiz.assignments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to List
                </a>
                @if($assignment->status === 'pending')
                    <a href="{{ route('candidate.quiz.assignments.start', $assignment->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Start Quiz
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.admin')

@section('title', 'Quiz Assignment Details')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz Assignment Details</h1>
            <div>
                <a href="{{ route('admin.quiz.assignments.edit', [$quiz->id, $assignment->id]) }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit Assignment
                </a>
                <a href="{{ route('admin.quiz.assignments.index', $quiz->id) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Back to Assignments
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quiz Information</h2>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Quiz Name:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $quiz->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $quiz->duration }} minutes</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Passing Marks:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $quiz->passing_marks }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Schedule Date:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $quiz->schedule_date }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Time:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $quiz->start_time }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Candidate Information</h2>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Name:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $assignment->candidate->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                <p class="text-base text-gray-800 dark:text-white">{{ $assignment->candidate->email }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</span>
                                <p class="text-base">
                                    @if ($assignment->status === 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($assignment->status === 'completed')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned At:</span>
                                <p class="text-base text-gray-800 dark:text-white">
                                    {{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y H:i') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed At:</span>
                                <p class="text-base text-gray-800 dark:text-white">
                                    {{ $assignment->completed_at ? $assignment->completed_at->format('M d, Y H:i') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Notes</h2>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        <p class="text-gray-800 dark:text-white">{{ $assignment->notes ?: 'No notes available.' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <form action="{{ route('admin.quiz.assignments.destroy', [$quiz->id, $assignment->id]) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('Are you sure you want to delete this assignment?')">
                            Delete Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

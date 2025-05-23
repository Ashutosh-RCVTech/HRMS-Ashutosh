@extends('layouts.admin')
@section('title', 'Edit Quiz Assignment')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Quiz Assignment</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6">
            <form action="{{ route('admin.quiz.assignments.update', [$quiz->id, $assignment->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quiz Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Quiz Name:</span>
                            <p class="text-base text-gray-800 dark:text-white">{{ $quiz->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration:</span>
                            <p class="text-base text-gray-800 dark:text-white">{{ $quiz->duration }} minutes</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Candidate Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Name:</span>
                            <p class="text-base text-gray-800 dark:text-white">{{ $assignment->candidate->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                            <p class="text-base text-gray-800 dark:text-white">{{ $assignment->candidate->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status
                    </label>
                    <select name="status" id="status"
                        class="form-select mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $assignment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $assignment->status === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="expired" {{ $assignment->status === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="form-textarea mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $assignment->notes }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.quiz.assignments.show', [$quiz->id, $assignment->id]) }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Update Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

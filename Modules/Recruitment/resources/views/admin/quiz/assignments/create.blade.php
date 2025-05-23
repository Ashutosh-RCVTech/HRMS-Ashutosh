@extends('layouts.admin')

@section('title', 'Assign Quiz to Candidates')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Assign Quiz: {{ $quiz->name }}</h1>
    </div>

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('warning') }}</span>
        </div>
    @endif

    @if(session('errors'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach(session('errors') as $error)
                    <li>Candidate ID: {{ $error['candidate_id'] }} - {{ $error['error'] }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6">
        <form action="{{ route('admin.quiz.assignments.store', $quiz->id) }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="candidate_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Select Candidates
                </label>
                <div class="border border-gray-300 dark:border-gray-600 rounded-md p-4 max-h-96 overflow-y-auto">
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Select All</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($candidates as $candidate)
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="candidate_ids[]" value="{{ $candidate->id }}" class="candidate-checkbox form-checkbox h-5 w-5 text-blue-600">
                                </div>
                                <div class="ml-3">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $candidate->name }}
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $candidate->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('candidate_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Notes (Optional)
                </label>
                <textarea name="notes" id="notes" rows="3" class="form-textarea mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.quiz.assignments.index', $quiz->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Assign Quiz
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const candidateCheckboxes = document.querySelectorAll('.candidate-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            candidateCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Update "Select All" checkbox based on individual checkboxes
        function updateSelectAllCheckbox() {
            const checkedCount = document.querySelectorAll('.candidate-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === candidateCheckboxes.length;
        }

        candidateCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAllCheckbox);
        });
    });
</script>
@endpush
@endsection 
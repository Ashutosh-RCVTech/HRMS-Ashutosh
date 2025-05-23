@extends('recruitment::college.layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Placement Drive</h1>
                <a href="{{ route('college.drives.index') }}" class="text-blue-600 hover:text-blue-800">
                    Back to List
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('college.drives.update', $drive->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $drive->title) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $drive->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="date" id="date"
                            value="{{ old('date', $drive->date->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                            Time</label>
                        <input type="time" name="start_time" id="start_time"
                            value="{{ old('start_time', $drive->start_time) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                            Time</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $drive->end_time) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="venue" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Venue</label>
                    <input type="text" name="venue" id="venue" value="{{ old('venue', $drive->venue) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="max_students" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maximum
                        Students</label>
                    <input type="number" name="max_students" id="max_students"
                        value="{{ old('max_students', $drive->max_students) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Eligibility Criteria</label>
                    <div id="eligibility-criteria" class="space-y-2">
                        @foreach (old('eligibility_criteria', $drive->eligibility_criteria) as $criterion)
                            <div class="flex gap-2">
                                <input type="text" name="eligibility_criteria[]" value="{{ $criterion }}"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <button type="button" class="remove-criterion text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-criterion" class="mt-2 text-blue-600 hover:text-blue-800">
                        + Add Criterion
                    </button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Required Documents</label>
                    <div id="required-documents" class="space-y-2">
                        @foreach (old('required_documents', $drive->required_documents) as $document)
                            <div class="flex gap-2">
                                <input type="text" name="required_documents[]" value="{{ $document }}"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <button type="button" class="remove-document text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-document" class="mt-2 text-blue-600 hover:text-blue-800">
                        + Add Document
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="city"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $drive->city) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="state"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                        <input type="text" name="state" id="state" value="{{ old('state', $drive->state) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="country"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                        <input type="text" name="country" id="country"
                            value="{{ old('country', $drive->country) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="pincode"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pincode</label>
                        <input type="text" name="pincode" id="pincode"
                            value="{{ old('pincode', $drive->pincode) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="status"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="active" {{ old('status', $drive->status) === 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="completed" {{ old('status', $drive->status) === 'completed' ? 'selected' : '' }}>
                            Completed</option>
                        <option value="cancelled" {{ old('status', $drive->status) === 'cancelled' ? 'selected' : '' }}>
                            Cancelled</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Drive
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add criterion
                document.getElementById('add-criterion').addEventListener('click', function() {
                    const container = document.getElementById('eligibility-criteria');
                    const div = document.createElement('div');
                    div.className = 'flex gap-2';
                    div.innerHTML = `
                <input type="text" name="eligibility_criteria[]"
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <button type="button" class="remove-criterion text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
                    container.appendChild(div);
                });

                // Add document
                document.getElementById('add-document').addEventListener('click', function() {
                    const container = document.getElementById('required-documents');
                    const div = document.createElement('div');
                    div.className = 'flex gap-2';
                    div.innerHTML = `
                <input type="text" name="required_documents[]"
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <button type="button" class="remove-document text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
                    container.appendChild(div);
                });

                // Remove criterion
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-criterion')) {
                        e.target.closest('.flex').remove();
                    }
                });

                // Remove document
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-document')) {
                        e.target.closest('.flex').remove();
                    }
                });
            });
        </script>
    @endpush
@endsection

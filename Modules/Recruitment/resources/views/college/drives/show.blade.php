@extends('recruitment::college.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $drive->title }}</h1>
            <div class="space-x-4">
                @if($drive->status === 'active')
                    <a href="{{ route('college.drives.edit', $drive->id) }}" 
                       class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Drive
                    </a>
                @endif
                <a href="{{ route('college.drives.index') }}" 
                   class="text-blue-600 hover:text-blue-800">
                    Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($drive->status === 'active') bg-green-100 text-green-800
                        @elseif($drive->status === 'completed') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($drive->status) }}
                    </span>
                    <div class="space-x-2">
                        @if($drive->status === 'active')
                            <form action="{{ route('college.drives.complete', $drive->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Completed
                                </button>
                            </form>
                            <form action="{{ route('college.drives.cancel', $drive->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel Drive
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h2>
                        <p class="text-gray-600 dark:text-gray-300">{{ $drive->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Date & Time</h2>
                            <div class="space-y-2 text-gray-600 dark:text-gray-300">
                                <p><strong>Date:</strong> {{ $drive->date->format('M d, Y') }}</p>
                                <p><strong>Start Time:</strong> {{ $drive->start_time }}</p>
                                <p><strong>End Time:</strong> {{ $drive->end_time }}</p>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Venue</h2>
                            <div class="space-y-2 text-gray-600 dark:text-gray-300">
                                <p>{{ $drive->venue }}</p>
                                <p>{{ $drive->city }}, {{ $drive->state }}</p>
                                <p>{{ $drive->country }} - {{ $drive->pincode }}</p>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Capacity</h2>
                            <div class="space-y-2 text-gray-600 dark:text-gray-300">
                                <p><strong>Maximum Students:</strong> {{ $drive->max_students }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Eligibility Criteria</h2>
                            <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-300">
                                @foreach($drive->eligibility_criteria as $criterion)
                                    <li>{{ $criterion }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Required Documents</h2>
                            <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-300">
                                @foreach($drive->required_documents as $document)
                                    <li>{{ $document }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if($drive->status === 'active')
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Drive Details</h2>
                            
                            <form action="{{ route('college.drives.reschedule', $drive->id) }}" method="POST" class="space-y-4 mb-6">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="new_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Date</label>
                                        <input type="date" name="new_date" id="new_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="new_start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Start Time</label>
                                        <input type="time" name="new_start_time" id="new_start_time"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="new_end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New End Time</label>
                                        <input type="time" name="new_end_time" id="new_end_time"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Reschedule Drive
                                    </button>
                                </div>
                            </form>

                            <form action="{{ route('college.drives.update-venue', $drive->id) }}" method="POST" class="space-y-4 mb-6">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="new_venue" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Venue</label>
                                    <input type="text" name="new_venue" id="new_venue"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Update Venue
                                    </button>
                                </div>
                            </form>

                            <form action="{{ route('college.drives.update-max-students', $drive->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="max_students" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Maximum Students</label>
                                    <input type="number" name="max_students" id="max_students" value="{{ $drive->max_students }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Update Capacity
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
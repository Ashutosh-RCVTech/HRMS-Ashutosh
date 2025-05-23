@extends('recruitment::candidate.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Placement Drives</h1>
            <p class="text-gray-600 dark:text-gray-400">View and participate in upcoming placement drives</p>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('candidate.placement.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">All</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Upcoming</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-md hover:bg-primary-600">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Placement Drives List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($placementDrives as $drive)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $drive['name'] }}
                            </h2>
                            <span class="px-3 py-1 rounded-full text-sm 
                                        @if ($drive->placementColleges->first()->status) bg-green-100 text-green-800 
                                        @else bg-blue-600 text-white @endif">
                                {{ $drive->placementColleges->first()->status ? 'completed' : 'UpComing' }}
                            </span>
                        </div>
                        <p class="description text-gray-600 dark:text-white text-sm mb-2">
                            {{ $drive['description'] }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4"> <strong>No. of Openings - </strong>
                            {{ $drive['no_of_openings'] }}</p>
                        <div class="flex justify-between items-center">

                            <a href="{{ route('candidate.placement.show', [$drive['id'], $collegeId]) }}"
                                class="bg-primary-500 text-white px-4 py-2 rounded-md hover:bg-primary-600">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.description').forEach(function (el) {
            const originalText = el.textContent.trim();
            if (originalText.length > 100) {
                el.textContent = originalText.substring(0, 300) + '...';
            }
        });
    });
</script>
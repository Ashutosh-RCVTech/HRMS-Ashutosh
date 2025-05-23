@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-6">
            <div class="bg-white dark:bg-slate-800 shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Quiz Schedules</h1>

                @if ($quizSchedules->isEmpty())
                    <p class="text-gray-500 dark:text-gray-300">No quiz schedules found for this placement.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">Placement</th>
                                    <th class="px-4 py-2 text-left">College</th>
                                    <th class="px-4 py-2 text-left">Course</th>
                                    <th class="px-4 py-2 text-left">Quiz</th>
                                    <th class="px-4 py-2 text-left">Date</th>
                                    <th class="px-4 py-2 text-left">Time</th>
                                    <th class="px-4 py-2 text-left">Timezone</th>
                                    <th class="px-4 py-2 text-left">Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($quizSchedules as $schedule)
                                    <tr>
                                        <td class="px-4 py-2">{{ $schedule->placement->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $schedule->college->college->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $schedule->course->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $schedule->quiz->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ $schedule->schedule_date }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                        <td class="px-4 py-2">{{ $schedule->timezone }}</td>
                                        <td class="px-4 py-2">{{ $schedule->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td><a href="{{ route('admin.placement.quiz.schedule.edit', $schedule->id) }}"
                                            class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit Schedule
                                        </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('admin.placement.show', $placementId) }}" class="text-indigo-600 hover:underline">
                        ← Back to Placement Details
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection

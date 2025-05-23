@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Edit Quiz</h1>
                </div>
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.quiz.courses.quizes.basic.info.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Quiz Name</label>
                        <input type="text" name="name" value="{{ $quiz->name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                focus:border-indigo-500 focus:ring-indigo-500 
                                dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Total Marks</label>
                        <input type="number" name="score" value="{{ $quiz->marks }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                focus:border-indigo-500 focus:ring-indigo-500 
                                dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Passing marks ( in %
                            )</label>
                        <input type="number" name="passing_marks" value="{{ $quiz->passing_marks }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                            focus:border-indigo-500 focus:ring-indigo-500 
                                            dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Duration (mins)</label>
                        <input type="number" name="duration" value="{{ $quiz->duration }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                focus:border-indigo-500 focus:ring-indigo-500 
                                dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    {{-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Date</label>
                        <input type="date" name="schedule_date" value="{{ $quiz->schedule_date }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                            focus:border-indigo-500 focus:ring-indigo-500 
                                            dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Time</label>
                        <input type="time" name="start_time" value="{{ $quiz->start_time }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                            focus:border-indigo-500 focus:ring-indigo-500 
                                            dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Timezone</label>
                        <select name="timezone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                 focus:border-indigo-500 focus:ring-indigo-500 
                                 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                            <option value="">Select a Timezone</option>
                            <option value="Asia/Kolkata" {{ $quiz->timezone == 'Asia/Kolkata' ? 'selected' : '' }}>India
                                (IST)
                            </option>
                            <option value="America/New_York" {{ $quiz->timezone == 'America/New_York' ? 'selected' : '' }}>
                                USA
                                (EST)</option>
                            <option value="America/Chicago" {{ $quiz->timezone == 'America/Chicago' ? 'selected' : '' }}>
                                USA
                                (CST)</option>
                            <option value="America/Denver" {{ $quiz->timezone == 'America/Denver' ? 'selected' : '' }}>USA
                                (MST)</option>
                            <option value="America/Los_Angeles"
                                {{ $quiz->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>USA (PST)</option>
                            <option value="Europe/London" {{ $quiz->timezone == 'Europe/London' ? 'selected' : '' }}>Europe
                                (GMT/BST)</option>
                            <option value="Europe/Berlin" {{ $quiz->timezone == 'Europe/Berlin' ? 'selected' : '' }}>Europe
                                (CET)</option>
                        </select>
                    </div> --}}

                    <button type="submit"
                        class=" inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                                                            rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                            hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                                                            focus:border-indigo-900 focus:ring ring-indigo-300 
                                                                            disabled:opacity-25 transition ease-in-out duration-150 mt-8">update
                        Quiz</button>
                </form>
            </div>
        </div>
    </main>
@endsection

@extends('layouts.admin')

@section('content')
<main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
            <h1 class="text-2xl font-bold mb-8">Edit Quiz Schedule</h1>

            <form method="POST" action="{{ route('admin.placement.quiz.schedule.update', $quizSchedule->id) }}" id="form_submit">
                @csrf
                @method('PUT')

                <input type="hidden" name="placement_id" value="{{ $quizSchedule->placement_id }}" id="placement_id">
                <input type="hidden" name="placement_college_id" value="{{ $quizSchedule->placement_college_id }}" id="college_id">

                <!-- Select Course -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Select Course</label>
                    <select name="course_id" id="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                        <option value="">-- Select Course --</option>
                        @foreach($quizCourses as $course)
                            <option value="{{ $course->id }}" {{ $quizSchedule->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Quiz -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Select Quiz</label>
                    <select name="quiz_id" id="quiz_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                        <option value="">-- Select Quiz --</option>
                        @foreach($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ $quizSchedule->quiz_id == $quiz->id ? 'selected' : '' }}>
                                {{ $quiz->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Schedule Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Date</label>
                    <input type="date" name="schedule_date" id="schedule_date" value="{{ $quizSchedule->schedule_date }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                </div>

                <!-- Start Time -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Time</label>
                    <input type="time" name="start_time" value="{{ $quizSchedule->start_time }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                </div>

                <!-- Timezone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Timezone</label>
                    <select name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                        <option value="">Select a Timezone</option>
                        @foreach([
                            'Asia/Kolkata' => 'India (IST)',
                            'America/New_York' => 'USA (EST)',
                            'America/Chicago' => 'USA (CST)',
                            'America/Denver' => 'USA (MST)',
                            'America/Los_Angeles' => 'USA (PST)',
                            'Europe/London' => 'Europe (GMT/BST)',
                            'Europe/Berlin' => 'Europe (CET)'
                        ] as $zone => $label)
                            <option value="{{ $zone }}" {{ $quizSchedule->timezone == $zone ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit -->
                <div class="mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                            rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                            hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                            focus:border-indigo-900 focus:ring ring-indigo-300 
                            disabled:opacity-25 transition ease-in-out duration-150">
                        Update Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('course_id').addEventListener('change', function () {
        const courseId = this.value;
        const quizDropdown = document.getElementById('quiz_id');
        quizDropdown.innerHTML = '<option value="">Loading...</option>';

        if (!courseId) {
            quizDropdown.innerHTML = '<option value="">-- Select Quiz --</option>';
            return;
        }

        fetch(`{{ url('admin/placement/fetch-quizzes-by-course') }}/${courseId}`)
            .then(response => response.json())
            .then(data => {
                quizDropdown.innerHTML = '<option value="">-- Select Quiz --</option>';
                data.forEach(quiz => {
                    quizDropdown.innerHTML += `<option value="${quiz.id}">${quiz.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading quizzes:', error);
                quizDropdown.innerHTML = '<option value="">Error loading quizzes</option>';
            });
    });
</script>
@endsection

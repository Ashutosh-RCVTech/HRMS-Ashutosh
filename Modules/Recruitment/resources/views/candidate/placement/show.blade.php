@extends('recruitment::candidate.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('candidate.placement.index') }}"
                class="text-primary-500 hover:text-primary-600 mb-4 inline-block">
                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Placement Drives
            </a>

            <div class="bg-white border-b border-gray-200 dark:bg-slate-800 dark:text-white rounded-xl shadow-md mb-6 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $placement->name }}</h1>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full 
                                                    {{ $placement->placementColleges->first()->status
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                                        : 'bg-blue-100 text-white-800 dark:bg-blue-800/30 dark:text-white-400' }}">
                                {{ $placement->placementColleges->first()->status ? 'completed' : 'UpComing' }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300">

                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $placement->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="md:flex md:gap-4 flex-col md:flex-row">
                <!-- First Column (60%) -->
                <div class="md:w-[35%] space-y-4">
                    <!-- Job Description -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">Job
                            Description</h2>
                        <div id="job-description-container" class="relative overflow-hidden transition-all duration-300">
                            <p id="job-description" class="text-gray-800 dark:text-gray-300 leading-relaxed">
                                {{ $placement->description }} </p>
                        </div>
                        <button id="toggle-description"
                            class="mt-2 text-blue-600 dark:text-blue-400 hover:underline focus:outline-none text-sm hidden">
                            Show More
                        </button>
                    </div>

                    <!-- Education Level -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">Education
                            Level</h2>
                        <p class="text-gray-800 dark:text-gray-300 leading-relaxed">
                            {{ $placement->educationLevel->name }}
                        </p>
                    </div>

                    <!-- Required Skills -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">Required
                            Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($placement->placementSkills as $skills)
                                <span
                                    class="px-2 py-1 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">
                                    {{ $skills->skill->name }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No specific skills mentioned</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Required Degree -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">Required
                            Degree</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($placement->placementDegrees as $degrees)
                                <span
                                    class="px-2 py-1 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">
                                    {{ $degrees->degree->name }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No specific degree mentioned</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Second Column (35%) -->
                <div class="md:w-[60%] space-y-4">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <div class="flex  gap-4 justify-between">
                            <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">
                                College Details</h2>

                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse($placement->placementColleges as $placementColleges)
                                <div class="flex justify-between gap-4 items-center w-full">
                                    <p class="text-gray-800 dark:text-gray-300 leading-relaxed">
                                        {{ $placementColleges->college->name }},
                                        {{ $placementColleges->college->address }},
                                        {{ $placementColleges->college->city }},
                                        {{ $placementColleges->college->pincode }}
                                    </p>


                                </div>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No specific college mentioned</p>
                            @endforelse
                        </div>
                    </div>


                    @if ($quizSchedule)
                        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                            <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:text-white dark:border-gray-700">Test
                                Details</h2>


                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed">
                                Date: {{ $quizSchedule->schedule_date }}
                            </p>
                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed">
                                Time : {{ \Carbon\Carbon::parse($quizSchedule->start_time)->format('h:i A') }}
                            </p>


                            <a href="{{ route('candidate.mcq.signin', [encrypt($placement->id), encrypt(request()->segment(4)), encrypt($quizSchedule->quiz_id)]) }}"
                                class="inline-flex mt-4 items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                Take Test
                            </a>



                        </div>
                    @endif
                </div>
            </div>



        </div>


    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const desc = document.getElementById('job-description');
        const toggleBtn = document.getElementById('toggle-description');
        const fullText = desc.textContent.trim();

        if (fullText.length > 100) {
            const truncated = fullText.slice(0, 300) + '...';
            let isExpanded = false;
            desc.textContent = truncated;
            toggleBtn.classList.remove('hidden');

            toggleBtn.addEventListener('click', () => {
                if (isExpanded) {
                    desc.textContent = truncated;
                    toggleBtn.textContent = "Show More";
                } else {
                    desc.textContent = fullText;
                    toggleBtn.textContent = "Show Less";
                }
                isExpanded = !isExpanded;
            });
        }
    });
</script>

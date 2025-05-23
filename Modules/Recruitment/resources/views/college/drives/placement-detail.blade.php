@extends('recruitment::college.layouts.app')

@section('content')
<main class="w-full px-4 sm:px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-lg mb-8 p-6 transition-all hover:shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-grow">
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-[250px]">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white break-words">{{ $placement->name }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="px-3 py-1 text-sm font-medium rounded-full inline-flex items-center 
                                            {{ $placement->status
                                            ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                            : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $placement->status ? 'Open' : 'Closed'}}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $placement->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Job Description Card -->
            <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Job Description</h2>
                </div>

                {{-- <div id="job-description-container" class="relative overflow-hidden transition-all duration-300">
                    <p id="job-description" class="text-gray-800 dark:text-gray-300 leading-relaxed">
                        {{ $placement->description }}
                    </p>
                </div>
                <button id="toggle-description"
                    class="mt-2 text-blue-600 dark:text-blue-400 hover:underline focus:outline-none text-sm hidden">
                    Show More
                </button> --}}
                <div class="relative">
                    <div class="prose dark:prose-invert text-gray-600 dark:text-gray-300 max-w-full">
                        <p id="job-description">
                            {{ $placement->description }}
                        </p>
                    </div>
                    <button id="toggle-description"
                    class="mt-2 text-blue-600 dark:text-blue-400 hover:underline focus:outline-none text-sm hidden">
                    Show More
                </button>
                </div>
            </div>

            <!-- Education Level Card -->
            <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Education Level</h2>
                </div>
                <div class="flex items-center gap-3 bg-gray-50 dark:bg-slate-700/30 rounded-lg p-3">
                    <span class="text-lg font-medium text-gray-700 dark:text-gray-200">
                        {{ $placement->educationLevel->name }}
                    </span>
                </div>
            </div>

            <!-- Number of Openings Card -->
            <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-pink-100 dark:bg-pink-900/20 rounded-lg">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Number of Openings</h2>
                </div>
                <div class="flex items-center gap-3 bg-gray-50 dark:bg-slate-700/30 rounded-lg p-3">
                    <span class="text-lg font-medium text-gray-700 dark:text-gray-200">
                        {{ $placement->no_of_openings }}
                    </span>
                </div>
            </div>

            <!-- Required Skills Card -->
            <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Required Skills</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse($placement->placementSkills as $skills)
                        <span class="px-3 py-1.5 text-sm bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full inline-flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $skills->skill->name }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No specific skills required</p>
                    @endforelse
                </div>
            </div>

            <!-- Required Degrees Card -->
            <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Required Degrees</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse($placement->placementDegrees as $degrees)
                        <span class="px-3 py-1.5 text-sm bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full inline-flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ $degrees->degree->name }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No specific degrees required</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const desc = document.getElementById('job-description');
        const toggleBtn = document.getElementById('toggle-description');
        const fullText = desc.textContent.trim();

        if (fullText.length > 100) {
            const truncated = fullText.slice(0, 200) + '...';
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

@endsection
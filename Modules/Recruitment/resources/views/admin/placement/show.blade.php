@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 dark:bg-slate-800 dark:text-white rounded-xl shadow-md mb-6 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $placement->name }}</h1>
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                        {{ $placement->status
        ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
        : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                {{   $placement->status ? 'Open' : 'Close'}}
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
            <div class="md:flex md:gap-4 flex-col w-full md:flex-row">
                <!-- First Column (60%) -->

                <div class="md:w-[66%] space-y-4">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <div class="flex  gap-4 justify-between">
                            <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">College Details</h2>
                            {{-- <a href="{{ route('admin.placement.add.college', $placement->id) }}"
                                class="inline-flex items-center px-2 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Add College
                            </a> --}}

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


                                                    <div>

                                                        @php
                                                        $status = $placementColleges->college_acceptance;
                                                    @endphp
                                                  
                                                    @switch($status)
                                                        @case(1)

                                                        <div class="flex gap-4 items-center">
                                        
                                                            <span class="px-2 py-1 text-xs font-medium ml-4 rounded-full 
                                                                         bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400">
                                                                Approved
                                                            </span>

                                                            <a href="{{ route('admin.placement.college.quiz.studuent', [$placement->id, $placementColleges->id]) }}"
                                                                class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                               
                                                                Details
                                                            </a>
                                                        </div>
                                                           
                                                            @break
                                                    
                                                        @case(2)
                                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                                         bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400">
                                                                Rejected
                                                            </span>

                                                            {{-- <a href=""
                                                                class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                                Reject Reason
                                                            </a> --}}
                                                            @break
                                                    
                                                        @default
                                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                                         bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-400">
                                                                Pending
                                                            </span>
                                                    @endswitch

                                                        
                                                    
                                                    </div>
                                                </div>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No specific college mentioned</p>
                            @endforelse
                        </div>
                    </div>
                </div>


                <div class="md:w-[30%] space-y-4">


                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Job Description</h2>
                        <div id="job-description-container" class="relative overflow-hidden transition-all duration-300">
                            <p id="job-description" class="text-gray-800 dark:text-gray-300 leading-relaxed">
                                {{ $placement->description }}
                            </p>
                        </div>
                        <button id="toggle-description"
                            class="mt-2 text-blue-600 dark:text-blue-400 hover:underline focus:outline-none text-sm hidden">
                            Show More
                        </button>
                    </div>


                    <!-- Education Level -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Education Level</h2>
                        <p class="text-gray-800 dark:text-gray-300 leading-relaxed">
                            {{ $placement->educationLevel->name }}
                        </p>
                    </div>

                    <!-- Required Skills -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Required Skills</h2>
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
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Required Degree</h2>
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
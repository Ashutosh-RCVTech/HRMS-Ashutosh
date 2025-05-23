@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white rounded-xl shadow-lg">
                <h1 class="text-2xl font-bold mb-8">Application Details</h1>

                <!-- Candidate & Job Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Candidate Information -->
                    <div class="bg-gray-50 dark:bg-slate-800 p-6 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4 dark:text-white">Candidate Information</h2>
                        <div class="space-y-2 text-gray-700 dark:text-gray-300">
                            <p><span class="font-medium">Name:</span> {{ $application->candidate->name }}</p>
                            <p><span class="font-medium">Email:</span> {{ $application->candidate->email }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $application->candidate->phone }}</p>
                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="bg-gray-50 dark:bg-slate-800 p-6 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4 dark:text-white">Job Information</h2>
                        <div class="space-y-2 text-gray-700 dark:text-gray-300">
                            <p><span class="font-medium">Title:</span> {{ $application->job->title }}</p>
                            <p><span class="font-medium">Client:</span> {{ $application->job->client }}</p>
                            <p><span class="font-medium">Experience:</span> {{ $application->job->experience_required }}
                                Years</p>
                            <div class="flex items-center gap-2">
                                <span class="font-medium">Status:</span>
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $application->status === 'accepted'
                                ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                : ($application->status === 'rejected'
                                    ? 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400'
                                    : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-400') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Application Materials -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4 dark:text-white">Attached Documents</h2>

                    <!-- Cover Letter -->
                    {{-- <div class="mb-6">
                        <p class="font-medium mb-2 dark:text-gray-300">Cover Letter</p>
                        <div class="bg-gray-50 dark:bg-slate-800 p-4 rounded-lg text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    </div> --}}
                    <div class="mb-6">
                        <p class="font-medium text-lg mb-2 dark:text-gray-300">Cover Letter</p>
                        <div class="bg-gray-150 dark:bg-slate-800 border border-gray-400 dark:border-slate-800 p-6 rounded-lg text-gray-900 dark:text-gray-300 leading-relaxed text-[15px] font-[450] prose dark:prose-invert max-w-none">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    </div>


                    <!-- Resume -->
                    <div>
                        <p class="font-medium mb-2 dark:text-gray-300">Resume</p>
                        @if ($application->resume_path)
                            <a href="{{ route('admin.job-applications.download', $application->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                Download Resume
                            </a>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">No resume uploaded</span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.job-applications.index') }}"
                        class="w-full sm:w-auto px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 text-center">
                        Back to List
                    </a>

                    @if ($application->status != 'withdrawn')
                        <form action="{{ route('admin.job-applications.destroy', $application->id) }}" method="POST"
                            class="w-full sm:w-auto"
                            onsubmit="return confirm('Are you sure you want to delete this application?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                Delete Application
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

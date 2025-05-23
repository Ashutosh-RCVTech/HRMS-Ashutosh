@extends('organization.layout')

@section('title', 'Candidate Profile')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start gap-6">
        <!-- Candidate Overview -->
        <div class="w-1/3 space-y-4">
            <div class="text-center">
                <img src="{{ $candidate->basicDetail->profile_image_path }}" class="w-32 h-32 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-semibold">{{ $candidate->name }}</h2>
                <p class="text-gray-600">{{ $candidate->careerProfile->current_industry ?? 'N/A' }}</p>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium">{{ $candidate->pivot->status ?? 'New' }}</span>
                </div>
                <!-- Add more quick stats -->
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="w-2/3">
            <div class="border-b pb-4 mb-4">
                <h3 class="text-lg font-semibold mb-2">Professional Summary</h3>
                <p class="text-gray-600">{{ $candidate->basicDetail->profile_summary ?? 'No summary provided' }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Employment History -->
                <div>
                    <h4 class="font-semibold mb-2">Work Experience</h4>
                    @foreach($candidate->employments as $employment)
                        <div class="mb-4">
                            <p class="font-medium">{{ $employment->position }}</p>
                            <p class="text-gray-600">{{ $employment->company }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $employment->start_date->format('M Y') }} -
                                {{ $employment->current ? 'Present' : $employment->end_date->format('M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- Education -->
                <div>
                    <h4 class="font-semibold mb-2">Education</h4>
                    @foreach($candidate->educations as $education)
                        <div class="mb-4">
                            <p class="font-medium">{{ $education->degree }}</p>
                            <p class="text-gray-600">{{ $education->institution }}</p>
                            <p class="text-sm text-gray-500">{{ $education->year }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-4">
                <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Shortlist
                </button>
                <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Reject
                </button>
                <a href="{{ $candidate->basicDetail->resume_path }}" target="_blank"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    View Resume
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

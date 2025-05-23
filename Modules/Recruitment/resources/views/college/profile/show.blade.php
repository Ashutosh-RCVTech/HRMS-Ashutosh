@extends('recruitment::college.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class=" mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Header Section -->
                <div class="relative h-48 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-end space-x-6">
                            <div
                                class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden bg-white dark:bg-gray-700">
                                @php
                                    $logoPath = $college->logo;
                                    $publicPath = $logoPath ? public_path('storage/' . $logoPath) : null;
                                    $assetUrl = $logoPath ? asset('storage/' . $logoPath) : null;

                                    // Log debugging information
                                    \Illuminate\Support\Facades\Log::info('College Logo Debug:', [
                                        'logo_path' => $logoPath,
                                        'public_path' => $publicPath,
                                        'asset_url' => $assetUrl,
                                        'file_exists' => $publicPath && file_exists($publicPath),
                                        'storage_path' => $logoPath ? storage_path('app/public/' . $logoPath) : null,
                                        'storage_exists' => $logoPath
                                            ? \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)
                                            : false,
                                    ]);
                                @endphp

                                @if ($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                                    <img src="{{ $assetUrl }}" alt="College Logo" class="w-full h-full object-cover"
                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400\'><svg class=\'w-16 h-16\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>';">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-white">{{ $college->name }}</h1>
                                <p class="text-blue-100 mt-1">{{ $college->city }}, {{ $college->state }}</p>
                            </div>
                            <div>
                                <a href="{{ route('college.profile.edit') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-6">
                    <!-- College Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">College Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->email }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->phone }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Website</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    @if ($college->website)
                                        <a href="{{ $college->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">{{ $college->website }}</a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Not provided</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                                <p class="mt-1">
                                    @if ($college->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Description</h2>
                        <p class="text-gray-600 dark:text-gray-300">{{ $college->description }}</p>
                    </div>

                    <!-- Address -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Street Address</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->address }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    {{ $college->city }}, {{ $college->state }}<br>
                                    {{ $college->country }} - {{ $college->pincode }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Person -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Contact Person</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->contact_person_name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Designation</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->contact_person_designation }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->contact_person_email }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</h3>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $college->contact_person_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Statistics</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Drives</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ $activeDrives->count() }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Drives</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ $upcomingDrives->count() }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Drives</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ $completedDrives->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

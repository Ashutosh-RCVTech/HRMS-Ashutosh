{{-- @extends('recruitment::college.layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">College Registration</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Complete your registration in two simple steps</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex items-center relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 bg-primary-600 border-primary-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                        viewBox="0 0 24 24" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user-plus">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                </div>
                                <div class="absolute top-0 text-center mt-16 w-32 text-xs font-medium text-primary-600">
                                    Basic Information</div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                            <div class="flex items-center relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-map-pin">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div
                                    class="absolute top-0 right-0.5 text-center mt-16 w-32 text-xs font-medium text-gray-500">
                                    Address & Contact</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('college.register') }}" id="registrationForm" class="space-y-6">
                @csrf

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Tab 1: Basic Information -->
                    <div class="tab-pane active" id="tab1">
                        <div class="space-y-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">College Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="website"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website
                                    (Optional)</label>
                                <input type="text" name="website" id="website" value="{{ old('website') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="https://example.com">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter your college website URL
                                    (optional)</p>
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" id="nextBtn"
                                    class="bg-primary-600 text-white px-6 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200">
                                    Next Step
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Address & Contact -->
                    <div class="tab-pane hidden" id="tab2">
                        <div class="space-y-6">
                            <div>
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                <textarea name="address" id="address" rows="2" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="city"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="state"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                                    <input type="text" name="state" id="state" value="{{ old('state') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="country"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                    <input type="text" name="country" id="country" value="{{ old('country') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="pincode"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Contact Person
                                    Information</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="contact_person_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact
                                            Person Name</label>
                                        <input type="text" name="contact_person_name" id="contact_person_name"
                                            value="{{ old('contact_person_name') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="contact_person_email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact
                                            Person Email</label>
                                        <input type="email" name="contact_person_email" id="contact_person_email"
                                            value="{{ old('contact_person_email') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="contact_person_phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact
                                            Person Phone</label>
                                        <input type="tel" name="contact_person_phone" id="contact_person_phone"
                                            value="{{ old('contact_person_phone') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="contact_person_designation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact
                                            Person Designation</label>
                                        <input type="text" name="contact_person_designation"
                                            id="contact_person_designation"
                                            value="{{ old('contact_person_designation') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Security</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                        <input type="password" name="password" id="password" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm
                                            Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <button type="button" id="prevBtn"
                                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                                    Previous Step
                                </button>
                                <button type="submit"
                                    class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200">
                                    Complete Registration
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('college.login') }}" class="text-sm text-primary-600 hover:text-primary-800">
                    Already registered? Sign in here
                </a>
            </div>
        </div>
    </div> --}}



`{{-- @extends('recruitment::college.layouts.app')

@section('content')
    <div
        class="min-h-screen flex flex-col justify-center items-center py-10 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
        <div class="w-full sm:max-w-4xl px-4 sm:px-0">
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden transition-all duration-300">
                <!-- Header Section -->
                <div class="relative bg-primary-600 dark:bg-primary-700 py-8 px-6 text-white">
                    <div class="absolute inset-0 bg-opacity-20 bg-black"></div>
                    <div class="relative z-10">
                        <h1 class="text-3xl font-bold mb-2">College Registration</h1>
                        <p class="text-white text-opacity-90">Join our network of educational institutions</p>
                    </div>
                </div>

                <!-- Progress Steps -->
                <div class="px-8 pt-8">
                    <div class="flex items-center">
                        <!-- Step 1 -->
                        <div class="flex items-center relative">
                            <div id="step1-circle"
                                class="rounded-full h-12 w-12 flex items-center justify-center text-white font-medium text-lg bg-primary-600 shadow-md transition-all duration-300">
                                1
                            </div>
                            <div id="step1-text"
                                class="absolute top-full mt-2 transform -translate-x-1/4 w-32 text-center text-sm font-medium text-primary-600 dark:text-primary-400">
                                Basic Information
                            </div>
                        </div>
                        <div id="progress-bar"
                            class="flex-auto border-t-4 mx-2 border-gray-200 dark:border-gray-700 transition-all duration-500">
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-center relative">
                            <div id="step2-circle"
                                class="rounded-full h-12 w-12 flex items-center justify-center text-gray-500 font-medium text-lg bg-gray-200 dark:bg-gray-700 shadow-md transition-all duration-300">
                                2
                            </div>
                            <div id="step2-text"
                                class="absolute top-full mt-2 transform -translate-x-3/4 w-32 text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                                Contact & Security
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('college.register') }}" id="registrationForm" class="p-8 pt-14">
                    @csrf --}}

                    <!-- Step 1 Content -->
                    {{-- <div id="tab1" class="tab-pane space-y-6">
                        <!-- Institution Details Section -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Institution Details</h3>

                            <div class="space-y-6">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">College
                                        Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                        placeholder="Enter your college name">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                            Address</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="college@example.edu">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                                            Number</label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="e.g., +91 9876543210">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="website"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website
                                    </label>
                                    <input type="url" name="website" id="website" value="{{ old('website') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                        placeholder="https://yourcollege.edu">
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Warning Message -->
                                <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/exclamation -->
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z <path fill-rule="evenodd" d="
                                                    M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213
                                                    2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1
                                                    0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Your website must:
                                            <ul class="list-disc pl-5 mt-1">
                                                <li>Match your email domain</li>
                                                <li>Contain your college name</li>
                                                <li>Be publicly accessible</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Institution
                                        Description</label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                        placeholder="Tell us about your institution...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="button" id="nextBtn"
                                class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                Continue <span class="ml-2">→</span>
                            </button>
                        </div>
                    </div>
                    <!-- Step 2 Content -->
                    <div id="tab2" class="tab-pane hidden space-y-8">
                        <div class="space-y-6">
                            <!-- Location Section -->
                            <div
                                class="bg-gray-50 dark:bg-gray-750 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Location Information
                                </h3>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                                            Address</label>
                                        <textarea name="address" id="address" rows="3" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="Street address, building, etc.">{{ old('address') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label for="city"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                                            <input type="text" name="city" id="city"
                                                value="{{ old('city') }}" required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                placeholder="Enter city name">
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="state"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                                                <input type="text" name="state" id="state"
                                                    value="{{ old('state') }}" required
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                    placeholder="Enter state">
                                                @error('state')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="pincode"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pincode</label>
                                                <input type="text" name="pincode" id="pincode"
                                                    value="{{ old('pincode') }}" required
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                    placeholder="Enter pincode">
                                                @error('pincode')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label for="country"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                                            <input type="text" name="country" id="country"
                                                value="{{ old('country', 'India') }}" required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                placeholder="Enter country">
                                            @error('country')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Person Section -->
                            <div
                                class="bg-gray-50 dark:bg-gray-750 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Contact Person Details
                                </h3>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="contact_person_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                                            Name</label>
                                        <input type="text" name="contact_person_name" id="contact_person_name"
                                            value="{{ old('contact_person_name') }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="Enter full name">
                                        @error('contact_person_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="contact_person_designation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Designation</label>
                                        <input type="text" name="contact_person_designation"
                                            id="contact_person_designation"
                                            value="{{ old('contact_person_designation') }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="e.g., Principal, Director">
                                        @error('contact_person_designation')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="contact_person_email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                            Address</label>
                                        <input type="email" name="contact_person_email" id="contact_person_email"
                                            value="{{ old('contact_person_email') }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="email@example.com">
                                        @error('contact_person_email')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="contact_person_phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                                            Number</label>
                                        <input type="tel" name="contact_person_phone" id="contact_person_phone"
                                            value="{{ old('contact_person_phone') }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                            placeholder="e.g., +91 9876543210">
                                        @error('contact_person_phone')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div
                                class="bg-gray-50 dark:bg-gray-750 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Account Security</h3>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                                        <div class="relative">
                                            <input type="password" name="password" id="password" required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                placeholder="Create a secure password">
                                            <button type="button" id="togglePassword"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must contain at least 8
                                            characters with uppercase, lowercase, number and special character</p>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm
                                            Password</label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition duration-200"
                                                placeholder="Re-enter your password">
                                            <button type="button" id="toggleConfirmPassword"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between pt-6">
                            <button type="button" id="prevBtn"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium shadow-md transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <span class="mr-2">←</span> Back
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Footer -->
                <div class="bg-gray-50 dark:bg-gray-900 p-6 text-center border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('college.login') }}"
                            class="text-primary-600 hover:text-primary-800 font-medium dark:text-primary-400 transition-colors duration-200">Sign
                            in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div> --}}

    @extends('recruitment::college.layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Content Area -->
        <div class="flex-1 lg:w-1/2 flex flex-col justify-between p-8 lg:p-12">
            <!-- Logo Section -->
            <div class="flex justify-between items-center">
                <a href="{{ route('college.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="h-10 dark:hidden" alt="College Portal">
                    <img src="{{ asset('images/logo/logo-white.png') }}" class="h-10 hidden dark:block" alt="College Portal">
                </a>
            </div>

            <!-- Registration Form Section -->
            <div class="max-w-md mx-auto w-full pt-8 lg:pt-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">College Registration</h1>
                    <p class="text-gray-600 dark:text-white">Join our network of educational institutions</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 rounded-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col items-center">
                            <div id="step1-circle" class="rounded-full h-10 w-10 flex items-center justify-center text-white font-medium bg-primary-600 shadow-md transition-all duration-300">
                                1
                            </div>
                            <span id="step1-text" class="mt-2 text-sm font-medium text-primary-600 dark:text-primary-400">Basic Info</span>
                        </div>
                        <div id="progress-bar" class="flex-1 mx-4 border-t-2 border-gray-200 dark:border-gray-700 transition-all duration-500"></div>
                        <div class="flex flex-col items-center">
                            <div id="step2-circle" class="rounded-full h-10 w-10 flex items-center justify-center font-medium bg-gray-200 dark:bg-gray-700 shadow-md transition-all duration-300">
                                2
                            </div>
                            <span id="step2-text" class="mt-2 text-sm font-medium text-gray-500 dark:text-gray-400">Contact & Security</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('college.register') }}" id="registrationForm" class="space-y-6">
                    @csrf
                    
                    <!-- Step 1 Content -->
                    <div id="tab1" class="tab-pane space-y-6">
                        <!-- Institution Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">College Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Enter your college name">
                        </div>

                        <!-- Email and Phone -->
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="college@example.edu">
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-white">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="+91 9876543210">
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="space-y-2">
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-white">Website</label>
                            <input type="url" name="website" id="website" value="{{ old('website') }}"
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="https://yourcollege.edu">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Must match your email domain and contain your college name</p>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-white">Institution Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Tell us about your institution...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Next Button -->
                        <button type="button" id="nextBtn"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Continue <span class="ml-2">→</span>
                        </button>
                    </div>

                    <!-- Step 2 Content -->
                    <div id="tab2" class="tab-pane hidden space-y-6">
                        <!-- Address -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-white">Full Address</label>
                            <textarea name="address" id="address" rows="3" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Street address, building, etc.">{{ old('address') }}</textarea>
                        </div>

                        <!-- City, State, Pincode -->
                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-white">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                    class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Enter city">
                            </div>
                            <div class="space-y-2">
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-white">State</label>
                                <input type="text" name="state" id="state" value="{{ old('state') }}" required
                                    class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Enter state">
                            </div>
                            <div class="space-y-2">
                                <label for="pincode" class="block text-sm font-medium text-gray-700 dark:text-white">Pincode</label>
                                <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}" required
                                    class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Enter pincode">
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="space-y-2">
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-white">Country</label>
                            <input type="text" name="country" id="country" value="{{ old('country', 'India') }}" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Enter country">
                        </div>

                        <!-- Contact Person -->
                        <div class="space-y-4 pt-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Person Details</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="contact_person_name" class="block text-sm font-medium text-gray-700 dark:text-white">Full Name</label>
                                    <input type="text" name="contact_person_name" id="contact_person_name" value="{{ old('contact_person_name') }}" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Enter full name">
                                </div>
                                <div class="space-y-2">
                                    <label for="contact_person_designation" class="block text-sm font-medium text-gray-700 dark:text-white">Designation</label>
                                    <input type="text" name="contact_person_designation" id="contact_person_designation" value="{{ old('contact_person_designation') }}" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="e.g., Principal">
                                </div>
                                <div class="space-y-2">
                                    <label for="contact_person_email" class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                                    <input type="email" name="contact_person_email" id="contact_person_email" value="{{ old('contact_person_email') }}" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="email@example.com">
                                </div>
                                <div class="space-y-2">
                                    <label for="contact_person_phone" class="block text-sm font-medium text-gray-700 dark:text-white">Phone</label>
                                    <input type="tel" name="contact_person_phone" id="contact_person_phone" value="{{ old('contact_person_phone') }}" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="+91 9876543210">
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="space-y-4 pt-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account Security</h3>
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Create a secure password">
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2"
                                        onclick="togglePassword('password')">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Must contain at least 8 characters with uppercase, lowercase, number and special character</p>
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-white">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Re-enter your password">
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2"
                                        onclick="togglePassword('password_confirmation')">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between pt-6">
                            <button type="button" id="prevBtn"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                ← Back
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Login Link -->
                <p class="text-center text-sm text-gray-600 dark:text-white mt-6">
                    Already have an account?
                    <a href="{{ route('college.login') }}"
                        class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                        Sign in here
                    </a>
                </p>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Terms</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Privacy</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Help</a>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} College Portal. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Right Image Section -->
        <div class="hidden lg:block lg:w-1/2 bg-[#F6FAFF] dark:bg-gray-900 p-12">
            <div class="relative h-full flex flex-col justify-center items-center">
                <!-- Decorative Elements -->
                <div class="absolute top-10 left-10">
                    <svg class="w-12 h-12 text-primary-500" fill="currentColor" viewBox="0 0 40 40">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 11L31.6667 13.35L16.6667 28.3333Z" />
                    </svg>
                </div>

                <!-- Main Content -->
                <div class="text-center max-w-md">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        College Partnership Portal
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-white">
                        Connect with top employers, manage student placements, and enhance your institution's
                        recruitment network.
                    </p>
                </div>

                <!-- Bottom Decoration -->
                <div class="absolute bottom-10 right-10">
                    <svg class="w-12 h-12 text-primary-500" fill="currentColor" viewBox="0 0 40 40">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM20 33.3333C12.65 33.3333 6.66671 27.35 6.66671 20C6.66671 12.65 12.65 6.66665 20 6.66665C27.35 6.66665 33.3334 12.65 33.3334 20C33.3334 27.35 27.35 33.3333 20 33.3333Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // const form = document.getElementById('registrationForm');
            const tab1 = document.getElementById('tab1');
            const tab2 = document.getElementById('tab2');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const progressBar = document.getElementById('progress-bar');
            const step1Circle = document.getElementById('step1-circle');
            const step2Circle = document.getElementById('step2-circle');
            const step1Text = document.getElementById('step1-text');
            const step2Text = document.getElementById('step2-text');
            // const togglePassword = document.getElementById('togglePassword');
            // const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            // const password = document.getElementById('password');
            // const passwordConfirmation = document.getElementById('password_confirmation');

            //Testing
            console.log(nextBtn);

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    console.log("Next button clicked");
                    tab1.classList.add('hidden');
                    tab2.classList.remove('hidden');

                    // Update progress bar and circles
                    progressBar.classList.add('border-primary-500');
                    progressBar.classList.remove('border-gray-200', 'dark:border-gray-700');

                    step1Circle.classList.add('bg-primary-600', 'text-white');
                    step2Circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');
                    // step2Circle.classList.add('bg-primary-600', 'text-white');

                    step2Text.classList.remove('text-gray-500', 'dark:text-gray-400');
                    step2Text.classList.add('text-primary-600', 'dark:text-primary-400');

                    // Scroll to top for better UX
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                
                })
            }

            if(prevBtn){
                prevBtn.addEventListener('click', () => {
                    console.log("Previous button clicked");
                    tab2.classList.add('hidden');
                    tab1.classList.remove('hidden');

                    // Update progress bar and circles
                    progressBar.classList.remove('border-primary-500');
                    progressBar.classList.add('border-gray-200', 'dark:border-gray-700');

                    step1Circle.classList.remove('bg-primary-600', 'text-white');
                    step2Circle.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');
                    step2Circle.classList.remove('bg-primary-600', 'text-white');

                    step2Text.classList.add('text-gray-500', 'dark:text-gray-400');
                    step2Text.classList.remove('text-primary-600', 'dark:text-primary-400');

                    // Scroll to top for better UX
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                })
            }
            

            // Handle password visibility toggle
            // togglePassword.addEventListener('click', function() {
            //     const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            //     password.setAttribute('type', type);
            //     this.querySelector('svg').classList.toggle('text-primary-500');
            // });

            // toggleConfirmPassword.addEventListener('click', function() {
            //     const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            //     passwordConfirmation.setAttribute('type', type);
            //     this.querySelector('svg').classList.toggle('text-primary-500');
            // });

            // Function to display field-specific errors
        //     function showFieldError(field, message) {
        //         // Remove any existing error
        //         const existingError = field.parentElement.querySelector('.text-red-600');
        //         if (existingError) {
        //             existingError.remove();
        //         }

        //         // Add the error class to input
        //         field.classList.add('border-red-500');

        //         // Create and append error message
        //         const errorElement = document.createElement('p');
        //         errorElement.classList.add('mt-1', 'text-sm', 'text-red-600', 'dark:text-red-400');
        //         errorElement.textContent = message;

        //         // Determine where to append the error
        //         if (field.parentElement.classList.contains('relative')) {
        //             field.parentElement.parentElement.appendChild(errorElement);
        //         } else {
        //             field.parentElement.appendChild(errorElement);
        //         }
        //     }

        //     // Function to clear field error
        //     function clearFieldError(field) {
        //         field.classList.remove('border-red-500');
        //         const errorElement = field.parentElement.querySelector('.text-red-600') ||
        //             (field.parentElement.parentElement.querySelector('.text-red-600'));
        //         if (errorElement) {
        //             errorElement.remove();
        //         }
        //     }

        //     // Function to validate tab 1 fields
        //     function validateTab1() {
        //         let isValid = true;
        //         const fields = [{
        //                 id: 'name',
        //                 message: 'College name is required',
        //                 regex: null
        //             },
        //             {
        //                 id: 'email',
        //                 message: 'Please enter a valid email address',
        //                 regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        //             },
        //             {
        //                 id: 'phone',
        //                 message: 'Please enter a valid phone number',
        //                 regex: /^(\+\d{1,3}[- ]?)?\d{10}$/
        //             }
        //         ];

        //         fields.forEach(field => {
        //             const input = document.getElementById(field.id);
        //             const value = input.value.trim();

        //             // Clear any existing errors first
        //             clearFieldError(input);

        //             // Required validation
        //             if (!value) {
        //                 showFieldError(input, field.message);
        //                 isValid = false;
        //                 return;
        //             }

        //             // Pattern validation if regex exists
        //             if (field.regex && !field.regex.test(value)) {
        //                 showFieldError(input, field.message);
        //                 isValid = false;
        //             }
        //         });

        //         // Website validation (optional field)
        //         const website = document.getElementById('website');
        //         if (website.value.trim()) {
        //             clearFieldError(website);
        //             const urlRegex = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;
        //             if (!urlRegex.test(website.value.trim())) {
        //                 showFieldError(website, 'Please enter a valid website URL');
        //                 isValid = false;
        //             }
        //         }

        //         return isValid;
        //     }

        //     // Function to validate tab 2 fields
        //     function validateTab2() {
        //         let isValid = true;

        //         // Basic required fields
        //         const requiredFields = [{
        //                 id: 'address',
        //                 message: 'Address is required'
        //             },
        //             {
        //                 id: 'city',
        //                 message: 'City is required'
        //             },
        //             {
        //                 id: 'state',
        //                 message: 'State is required'
        //             },
        //             {
        //                 id: 'country',
        //                 message: 'Country is required'
        //             },
        //             {
        //                 id: 'pincode',
        //                 message: 'Pincode is required'
        //             },
        //             {
        //                 id: 'contact_person_name',
        //                 message: 'Contact person name is required'
        //             },
        //             {
        //                 id: 'contact_person_designation',
        //                 message: 'Designation is required'
        //             }
        //         ];

        //         requiredFields.forEach(field => {
        //             const input = document.getElementById(field.id);
        //             clearFieldError(input);

        //             if (!input.value.trim()) {
        //                 showFieldError(input, field.message);
        //                 isValid = false;
        //             }
        //         });

        //         // Email validation
        //         const contactEmail = document.getElementById('contact_person_email');
        //         clearFieldError(contactEmail);

        //         if (!contactEmail.value.trim()) {
        //             showFieldError(contactEmail, 'Contact email is required');
        //             isValid = false;
        //         } else {
        //             const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //             if (!emailRegex.test(contactEmail.value.trim())) {
        //                 showFieldError(contactEmail, 'Please enter a valid email address');
        //                 isValid = false;
        //             }
        //         }

        //         // Phone validation
        //         const contactPhone = document.getElementById('contact_person_phone');
        //         clearFieldError(contactPhone);

        //         if (!contactPhone.value.trim()) {
        //             showFieldError(contactPhone, 'Contact phone is required');
        //             isValid = false;
        //         } else {
        //             const phoneRegex = /^(\+\d{1,3}[- ]?)?\d{10}$/;
        //             if (!phoneRegex.test(contactPhone.value.trim())) {
        //                 showFieldError(contactPhone, 'Please enter a valid phone number');
        //                 isValid = false;
        //             }
        //         }

        //         // Password validation
        //         const passwordInput = document.getElementById('password');
        //         clearFieldError(passwordInput);

        //         if (!passwordInput.value) {
        //             showFieldError(passwordInput, 'Password is required');
        //             isValid = false;
        //         } else if (passwordInput.value.length < 8) {
        //             showFieldError(passwordInput, 'Password must be at least 8 characters long');
        //             isValid = false;
        //         } else {
        //             // Check for password complexity
        //             const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        //             if (!passwordRegex.test(passwordInput.value)) {
        //                 showFieldError(passwordInput,
        //                     'Password must contain uppercase, lowercase, number and special character');
        //                 isValid = false;
        //             }
        //         }

        //         // Password confirmation validation
        //         const confirmInput = document.getElementById('password_confirmation');
        //         clearFieldError(confirmInput);

        //         if (!confirmInput.value) {
        //             showFieldError(confirmInput, 'Please confirm your password');
        //             isValid = false;
        //         } else if (confirmInput.value !== passwordInput.value) {
        //             showFieldError(confirmInput, 'Passwords do not match');
        //             isValid = false;
        //         }

        //         return isValid;
        //     }

        //     // Function to move to next tab
        //     function goToNextTab() {
        //         if (validateTab1()) {
        //             tab1.classList.add('hidden');
        //             tab2.classList.remove('hidden');

        //             // Update progress bar and circles
        //             progressBar.classList.add('border-primary-500');
        //             progressBar.classList.remove('border-gray-200', 'dark:border-gray-700');

        //             step1Circle.classList.add('bg-primary-600', 'text-white');
        //             step2Circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');
        //             step2Circle.classList.add('bg-primary-600', 'text-white');

        //             step2Text.classList.remove('text-gray-500', 'dark:text-gray-400');
        //             step2Text.classList.add('text-primary-600', 'dark:text-primary-400');

        //             // Scroll to top for better UX
        //             window.scrollTo({
        //                 top: 0,
        //                 behavior: 'smooth'
        //             });
        //         }
        //     }

        //     // Function to move to previous tab
        //     function goToPrevTab() {
        //         tab2.classList.add('hidden');
        //         tab1.classList.remove('hidden');

        //         // Reset progress bar and circles
        //         progressBar.classList.remove('border-primary-500');
        //         progressBar.classList.add('border-gray-200', 'dark:border-gray-700');

        //         step2Circle.classList.remove('bg-primary-600', 'text-white');
        //         step2Circle.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');

        //         step2Text.classList.add('text-gray-500', 'dark:text-gray-400');
        //         step2Text.classList.remove('text-primary-600', 'dark:text-primary-400');

        //         // Scroll to top for better UX
        //         window.scrollTo({
        //             top: 0,
        //             behavior: 'smooth'
        //         });
        //     }

        //     // Handle form submission
        //     form.addEventListener('submit', function(e) {
        //         e.preventDefault();

        //         if (tab1.classList.contains('hidden')) {
        //             // We're on tab 2
        //             if (validateTab2()) {
        //                 // All validations passed, submit the form
        //                 this.submit();
        //             }
        //         } else {
        //             // We're on tab 1, move to tab 2
        //             goToNextTab();
        //         }
        //     });

        //     // Next button click event
        //     nextBtn.addEventListener('click', goToNextTab);

        //     // Previous button click event
        //     prevBtn.addEventListener('click', goToPrevTab);

        //     // Add keyboard support for navigation
        //     document.addEventListener('keydown', function(e) {
        //         if (e.key === 'Enter' && e.ctrlKey) {
        //             if (tab1.classList.contains('hidden')) {
        //                 // We're on tab 2, submit the form
        //                 if (validateTab2()) {
        //                     form.submit();
        //                 }
        //             } else {
        //                 // We're on tab 1, move to tab 2
        //                 goToNextTab();
        //             }
        //         }
        //     });

        //     // Add responsive validation as user types in fields
        //     const allInputs = form.querySelectorAll('input, textarea');
        //     allInputs.forEach(input => {
        //         input.addEventListener('blur', function() {
        //             // Don't validate empty optional fields
        //             if (this.id === 'website' && !this.value.trim()) {
        //                 clearFieldError(this);
        //                 return;
        //             }

        //             if (tab1.contains(this)) {
        //                 // For tab 1 fields
        //                 const field = {
        //                     id: this.id,
        //                     message: this.id.charAt(0).toUpperCase() + this.id.slice(1) +
        //                         ' is required'
        //                 };

        //                 if (this.id === 'email') {
        //                     field.regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //                     field.message = 'Please enter a valid email address';
        //                 } else if (this.id === 'phone') {
        //                     field.regex = /^(\+\d{1,3}[- ]?)?\d{10}$/;
        //                     field.message = 'Please enter a valid phone number';
        //                 } else if (this.id === 'website' && this.value.trim()) {
        //                     field.regex =
        //                         /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;
        //                     field.message = 'Please enter a valid website URL';
        //                 }

        //                 // Clear any existing errors
        //                 clearFieldError(this);

        //                 // Required validation
        //                 if (!this.value.trim() && this.id !== 'website') {
        //                     showFieldError(this, field.message);
        //                     return;
        //                 }

        //                 // Pattern validation
        //                 if (field.regex && !field.regex.test(this.value.trim())) {
        //                     showFieldError(this, field.message);
        //                 }
        //             }
        //         });
        //     });

        //     // Initialize form with any existing errors from server-side validation
        //     const serverErrors = document.querySelectorAll('.text-red-600');
        //     if (serverErrors.length > 0) {
        //         // If errors exist on fields in tab 2, show tab 2
        //         const tab2Errors = Array.from(serverErrors).some(error => {
        //             const fieldId = error.previousElementSibling.id;
        //             return tab2.contains(document.getElementById(fieldId));
        //         });

        //         if (tab2Errors) {
        //             goToNextTab();
        //         }
        //     }
        });
    </script>
@endsection

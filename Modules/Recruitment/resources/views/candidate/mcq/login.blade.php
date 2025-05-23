<x-candidate-guest-layout title="Candidate MCQ Login">
    <div class="flex flex-col lg:flex-row">
        <div class="flex-1 lg:w-1/2 flex flex-col justify-between p-8 lg:p-12">
            <!-- Logo Section -->
            <div class="flex justify-between items-center">
                <a href="{{ route('candidate.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="h-10 dark:hidden" alt="RCV Recruitment" />
                    <img src="{{ asset('images/logo/logo-white.png') }}" class="h-10 hidden dark:block"
                        alt="RCV Recruitment" />
                </a>
            </div>

            <!-- Login Form Section -->
            <div class="max-w-md mx-auto w-full pt-8 lg:pt-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Welcome to MCQ Test</h1>
                    <p class="text-gray-600 dark:text-white">Enter your credentials to access your test</p>
                </div>

                <!-- Display session status if available -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Display general error message -->
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <p class="font-medium">Please correct the following errors:</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('candidate.mcq.login') }}" class="space-y-6">
                    @csrf
                    <!-- Hidden Quiz ID Field -->
                    <input type="hidden" name="placement_id" value="{{ request()->segment(6) }}">
                    <input type="hidden" name="college_id" value="{{ request()->segment(7) }}">
                    <input type="hidden" name="quiz_id" value="{{ request()->segment(8) }}">



                    @error('quiz_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    @error('placement_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    @error('college_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror





                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email
                            Address</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border @error('email') border-red-500 @else border-gray-300 dark:border-darkblack-400 @enderror dark:bg-slate-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border @error('password') border-red-500 @else border-gray-300 dark:border-darkblack-400 @enderror dark:bg-slate-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2"
                                onclick="togglePassword()">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember"
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded dark:bg-slate-900 dark:border-darkblack-400 focus:ring-primary-500" />
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-white">Remember
                                me</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Sign in
                    </button>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Terms</a>
                    <a href="#"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Privacy</a>
                    <a href="#"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-white">Help</a>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} RCV Technologies. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Right Image Section -->
        <div class="hidden lg:block lg:w-1/2 bg-[#F6FAFF] dark:bg-slate-900 p-12">
            <div class="relative h-full flex flex-col justify-center items-center">
                <!-- Decorative Elements -->
                <div class="absolute top-10 left-10">
                    <svg class="w-12 h-12 text-primary-500" fill="currentColor" viewBox="0 0 40 40">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 11L31.6667 13.35L16.6667 28.3333Z" />
                    </svg>
                </div>

                <!-- Guidelines Content -->
                <div class="text-left max-w-md space-y-6">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        MCQ Exam Guidelines
                    </h2>

                    <ol class="list-decimal space-y-4 text-gray-600 dark:text-gray-300 pl-5">
                        <li class="pb-2">
                            <strong class="block">Time Limit:</strong>
                            The exam must be completed within the allocated time. Timer starts when you begin.
                        </li>
                        <li class="pb-2">
                            <strong class="block">Navigation:</strong>
                            Once moved to next question, you can return to previous ones.
                        </li>
                        <li class="pb-2">
                            <strong class="block">Submission:</strong>
                            Answers are auto-submitted when time expires. Click submit button to finish early.
                        </li>
                        <li class="pb-2">
                            <strong class="block">Technical Requirements:</strong>
                            Ensure stable internet connection. Page refresh will count as an attempt.
                        </li>
                        <li class="pb-2">
                            <strong class="block">Honesty Policy:</strong>
                            No external resources allowed. Violations lead to disqualification.
                        </li>
                    </ol>

                    <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">
                        Note: Read questions carefully before answering. Good luck!
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

    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</x-candidate-guest-layout>

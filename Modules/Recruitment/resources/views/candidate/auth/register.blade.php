<x-candidate-guest-layout title="Candidate Registration">

    <div class="flex flex-col lg:flex-row">

        <!-- Left Content Area -->
        <div class="flex-1 lg:w-1/2 flex flex-col justify-between p-8 lg:p-12">
            <!-- Logo Section -->
            <div class="flex justify-between items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="h-10 dark:hidden" alt="RCV Recruitment" />
                    <img src="{{ asset('images/logo/logo-white.png') }}" class="h-10 hidden dark:block"
                        alt="RCV Recruitment" />
                </a>
            </div>

            <!-- Registration Form Section -->
            <div class="max-w-md mx-auto w-full pt-8 lg:pt-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Create Your Account</h1>
                    <p class="text-gray-600 dark:text-white">Fill in the details to register</p>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('candidate.register') }}" class="space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Full
                            Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-darkblack-400 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-darkblack-400 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use a valid email format (e.g.,
                            example@domain.com)</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-darkblack-400 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                            <button type="button" class="absolute right-3 top-[50%] -translate-y-1/2"
                                onclick="togglePassword('password')">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>


                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Password must have at least 6
                            characters
                            with one uppercase letter, one number, and one special character (@$!%*?&)</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Confirm Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-darkblack-400 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password_confirmation') border-red-500 @enderror">
                            <button type="button" class="absolute right-3 top-[50%] -translate-y-1/2"
                                onclick="togglePassword('password_confirmation')">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Register
                    </button>

                    <!-- Social Login Options -->
                    {{-- <div class="mt-6">
                <a href="{{ route('auth.google.login') }}"
                    class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                    <span class="ml-3">Sign in with Google</span>
                </a>
            </div>

            <div class="mt-6">
                <a href="{{ route('auth.github.login') }}"
                    class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                    </svg>
                    <span class="ml-3">Sign in with GitHub</span>
                </a>
            </div> --}}

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 dark:text-white">
                        Already have an account?
                        <a href="{{ route('candidate.login') }}"
                            class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                            Sign in
                        </a>
                    </p>
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
                <div class="absolute top-10 left-10">
                    <svg class="w-12 h-12 text-primary-500" fill="currentColor" viewBox="0 0 40 40">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 11L31.6667 13.35L16.6667 28.3333Z" />
                    </svg>
                </div>

                <div class="text-center max-w-md">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        Transform Your Selection Process
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-white">
                        Access powerful tools to smooth recruitment, connect with top companies, and make better
                        career decisions.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</x-candidate-guest-layout>

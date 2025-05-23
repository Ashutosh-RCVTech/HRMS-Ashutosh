{{-- @extends('recruitment::college.layouts.app')

@section('content')
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div
            class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden transform transition-all">
            <!-- Logo Section -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo/logo-color.png') }}" alt="Logo"
                    class="h-12 mx-auto mb-4 dark:hidden">
                <img src="{{ asset('images/logo/logo-white.png') }}" alt="Logo"
                    class="h-12 mx-auto mb-4 hidden dark:block">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome Back!</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Please sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-red-800 dark:text-red-200 font-medium">Oops! Something went wrong</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('college.login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="your@email.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="pl-10 w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                                fill="none" id="eye-icon" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" value="1"
                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 transition-colors duration-200">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Remember me
                        </label>
                    </div>

                    <a href="{{ route('college.password.request') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                        Forgot password?
                    </a>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center items-center px-4 py-3 bg-primary-500 hover:bg-primary-600 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 text-white font-semibold rounded-xl shadow-sm transform transition-all duration-200 hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign In
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <span class="text-gray-600 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ route('college.register') }}"
                        class="ml-1 font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                        Create one now
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
            }
        }
    </script>
@endsection --}}




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

            <!-- Login Form Section -->
            <div class="max-w-md mx-auto w-full pt-8 lg:pt-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">College Portal Login</h1>
                    <p class="text-gray-600 dark:text-white">Enter your credentials to access your institution's account
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('college.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email
                            Address</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                value="{{ old('email') }}" placeholder="institution@example.edu" autofocus>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="••••••••">
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2"
                                onclick="togglePassword()">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember"
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-600 focus:ring-primary-500">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-white">Remember
                                me</label>
                        </div>
                        @if (Route::has('college.password.request'))
                            <a href="{{ route('college.password.request') }}"
                                class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Sign in
                    </button>

                    <!-- Registration Link -->
                    <p class="text-center text-sm text-gray-600 dark:text-white">
                        Don't have an institution account?
                        <a href="{{ route('college.register') }}"
                            class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                            Register your college
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
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>

    <script>
        $(document).ready(function() {
            // Check verification status
            $.get('{{ route('college.verification.status') }}', function(response) {
                if (response.verified) {
                    window.location.href = '{{ route('college.dashboard') }}';
                }
            });
        });
    </script>
@endsection

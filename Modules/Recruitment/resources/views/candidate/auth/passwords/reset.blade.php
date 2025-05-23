<x-candidate-guest-layout>
    <div class="flex flex-col lg:flex-row">
        <!-- Left Content Area -->
        <div class="flex-1 lg:w-1/2 flex flex-col justify-between p-8 lg:p-12">
            <!-- Logo Section -->
            <div class="flex justify-between items-center">
                <a href="{{ route('candidate.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="h-10 dark:hidden" alt="RCV Recruitment" />
                    <img src="{{ asset('images/logo/logo-white.png') }}" class="h-10 hidden dark:block"
                        alt="RCV Recruitment" />
                </a>
            </div>

            <!-- Reset Password Form Section -->
            <div class="max-w-md mx-auto w-full pt-8 lg:pt-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Create New Password</h1>
                    <p class="text-gray-600 dark:text-white">Please enter your new password to continue</p>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('candidate.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">
                            New Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-darkblack-400 dark:bg-slate-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <svg id="passwordToggleIcon" class="w-5 h-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-white">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="block w-full px-4 py-3.5 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-darkblack-400 dark:bg-slate-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <button type="button" id="togglePasswordConfirmation"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <svg id="passwordConfirmationToggleIcon" class="w-5 h-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <p>Password must:</p>
                        <ul class="list-disc pl-5 space-y-1 mt-1">
                            <li>Be at least 6 characters long</li>
                            <li>Contain at least one uppercase letter</li>
                            <li>Contain at least one number</li>
                            <li>Contain at least one special character (@$!%*?&#)</li>
                        </ul>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            Reset Password
                        </button>
                    </div>
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

                <!-- Main Content -->
                <div class="text-center max-w-md">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        Create a Strong Password
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-white">
                        Choose a secure password that you'll remember. A strong password helps protect your account from
                        unauthorized access.
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
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const togglePasswordConfirmationBtn = document.getElementById('togglePasswordConfirmation');
            const passwordToggleIcon = document.getElementById('passwordToggleIcon');
            const passwordConfirmationToggleIcon = document.getElementById('passwordConfirmationToggleIcon');

            function togglePasswordVisibility(input, icon) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Update icon to show/hide state
                const pathElements = icon.getElementsByTagName('path');
                if (type === 'text') {
                    // Hide icon - cross out the eye
                    pathElements[1].setAttribute('d',
                        'M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19 12 19a9.455 9.455 0 002.13-.235m4.257-4.456c-.008-.322-.015-.643-.032-.966a10.709 10.709 0 01-.09-1.09c-.016-.625-.067-1.238-.157-1.84a6.611 6.611 0 00-1.013-2.345 6.625 6.625 0 00-2.395-1.861c-.844-.406-1.761-.619-2.69-.619l.29.594-1.028 1.027'
                    );
                } else {
                    // Show full eye icon
                    pathElements[1].setAttribute('d',
                        'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                    );
                }
            }

            togglePasswordBtn.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput, passwordToggleIcon);
            });

            togglePasswordConfirmationBtn.addEventListener('click', function() {
                togglePasswordVisibility(passwordConfirmationInput, passwordConfirmationToggleIcon);
            });
        });
    </script>
</x-candidate-guest-layout>

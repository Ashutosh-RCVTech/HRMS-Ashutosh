<x-candidate-guest-layout title="Candidate Verification">
    <div class="justify-center items-center py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                Verify Your Email Address
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Thanks for signing up! Before getting started, please verify your email address by clicking on
                        the
                        link we just emailed to you.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mt-4 rounded-md bg-green-50 dark:bg-green-900/30 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                    A new verification link has been sent to your email address.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-6">
                    <div class="space-y-4">
                        <form method="POST" action="{{ route('candidate.verification.send') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-150 ease-in-out">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('candidate.logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                Troubleshooting
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Didn't receive the email? Please check your spam folder or try resending the verification
                            link.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check if email is verified every 3 seconds and redirect if verified
        function checkEmailVerificationStatus() {
            fetch('{{ route('candidate.verification.status') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        window.location.href = '{{ route('candidate.dashboard') }}';
                    }
                })
                .catch(error => {
                    console.error('Error checking verification status:', error);
                });
        }

        // Initial check and then set interval
        checkEmailVerificationStatus();
        const intervalId = setInterval(checkEmailVerificationStatus, 3000);

        // Clear interval when page is unloaded
        window.addEventListener('beforeunload', function() {
            clearInterval(intervalId);
        });
    </script>
</x-candidate-guest-layout>

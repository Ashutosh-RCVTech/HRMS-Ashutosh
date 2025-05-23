@extends('recruitment::college.layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Verify Your Email Address</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                    link we just emailed to you?
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('college.verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:bg-primary-600 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Resend Verification Email
                    </button>
                </form>

                {{-- <form method="POST" action="{{ route('college.logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Log Out
                    </button>
                </form> --}}
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Didn't receive the email? Check your spam folder or try resending the verification link.
                </p>
            </div>
        </div>
    </div>
@endsection

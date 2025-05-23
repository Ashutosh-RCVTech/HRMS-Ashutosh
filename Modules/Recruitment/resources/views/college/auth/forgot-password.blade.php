@extends('recruitment::college.layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('college.password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-primary-900 focus:outline-none focus:border-indigo-900 focus:ring ring-primary-300 disabled:opacity-25 transition">
                        Send Password Reset Link
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('college.login') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection

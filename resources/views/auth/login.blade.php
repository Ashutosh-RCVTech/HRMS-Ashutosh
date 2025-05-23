<x-guest-layout>
    <section class="bg-white dark:bg-slate-900">
        <div class="flex flex-col lg:flex-row justify-between min-h-screen">
            <!-- Left -->
            <div class="lg:w-1/2 px-5 xl:pl-12 pt-10">
                <header>
                    <a href="{{ route('admin.dashboard') }}" class="">
                        <img src="{{ asset('images/logo/logo-color.png') }}" class="block dark:hidden h-12 w-20"
                            alt="Logo" />

                        {{-- <svg class="block dark:hidden  h-20 w-24" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                            <style>
                                .rcv-text {
                                    font-family: 'Arial', sans-serif;
                                    font-weight: bold;
                                }
                            </style>
                            <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%"
                                y2="0%">
                                <stop offset="0%" stop-color="#3498db" />
                                <stop offset="100%" stop-color="#2563eb" />
                            </linearGradient>
                            <rect x="20" y="30" width="60" height="60" rx="10"
                                fill="url(#logo-gradient)" />
                            <path d="M30 50 L50 40 L50 80 L30 70 Z" fill="white" />
                            <path d="M70 50 L50 40 L50 80 L70 70 Z" fill="#f0f9ff" />
                            <text x="90" y="65" class="rcv-text" fill="#2563eb" font-size="24">RCV</text>
                            <text x="90" y="85" class="rcv-text" fill="#64748b" font-size="14">Recruitment</text>
                        </svg> --}}

                        <img src="{{ asset('images/logo/logo-white.png') }}" class="hidden dark:block h-12 w-20"
                            alt="Logo" />
                        {{-- <svg class="hidden dark:block h-20 w-24" viewBox="0 0 200 120"
                            xmlns="http://www.w3.org/2000/svg">
                            <style>
                                .rcv-text {
                                    font-family: 'Arial', sans-serif;
                                    font-weight: bold;
                                }
                            </style>
                            <rect x="20" y="30" width="60" height="60" rx="10" fill="#ffffff" />
                            <path d="M30 50 L50 40 L50 80 L30 70 Z" fill="#2563eb" />
                            <path d="M70 50 L50 40 L50 80 L70 70 Z" fill="#3498db" />
                            <text x="90" y="65" class="rcv-text" fill="white" font-size="24">RCV</text>
                            <text x="90" y="85" class="rcv-text" fill="white" font-size="14">Recruitment</text>
                        </svg> --}}
                    </a>
                </header>
                <div class="max-w-[450px] m-auto pt-24 pb-16">
                    <header class="text-center mb-8">
                        <h2 class="text-bgray-900 dark:text-white text-4xl font-semibold font-poppins mb-2">
                            Log in to RCV Recruitment.
                        </h2>
                        <p class="font-urbanis text-base font-medium text-bgray-600 dark:text-white">
                            Streamlining Hiring, Empowering Talent, Elevating Businesses.
                        </p>
                    </header>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div
                            class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-800 rounded-lg">
                            <div class="text-red-600 dark:text-red-400 font-medium">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <input type="email"
                                class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-slate-900 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base @error('email') border-red-500 dark:border-red-500 @enderror"
                                name="email" placeholder="Username or email" value="{{ old('email') }}" required />
                        </div>
                        <div class="mb-6 relative">
                            <input type="password"
                                class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-slate-900 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base @error('password') border-red-500 dark:border-red-500 @enderror"
                                name="password" placeholder="Password" required />

                            <!-- SVG for password visibility toggle (Optional - JavaScript needed) -->
                            <button type="button" class="absolute top-4 right-4 bottom-4" id="toggle-password">
                                <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 1L20 19" stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9.58445 8.58704C9.20917 8.96205 8.99823 9.47079 8.99805 10.0013C8.99786 10.5319 9.20844 11.0408 9.58345 11.416C9.95847 11.7913 10.4672 12.0023 10.9977 12.0024C11.5283 12.0026 12.0372 11.7921 12.4125 11.417"
                                        stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M8.363 3.36506C9.22042 3.11978 10.1082 2.9969 11 3.00006C15 3.00006 18.333 5.33306 21 10.0001C20.222 11.3611 19.388 12.5241 18.497 13.4881M16.357 15.3491C14.726 16.4491 12.942 17.0001 11 17.0001C7 17.0001 3.667 14.6671 1 10.0001C2.369 7.60506 3.913 5.82506 5.632 4.65906"
                                        stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between mb-7">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox"
                                    class="w-5 h-5 dark:bg-slate-900 focus:ring-transparent rounded-full border border-bgray-300 focus:accent-success-300 text-primary-500"
                                    name="remember" id="remember" />
                                <label for="remember"
                                    class="text-bgray-900 dark:text-white text-base font-semibold">Remember me</label>
                            </div>
                            {{-- <div>
                                <a href="{{ route('password.request') }}"
                                    class="text-primary-500 font-semibold text-base underline">Forgot
                                    Password?</a>
                            </div> --}}
                        </div>
                        <!-- Change 'a' tag to a button with type="submit" -->
                        <button type="submit"
                            class="py-3.5 flex items-center justify-center text-white font-bold bg-primary-500 hover:bg-primary-600 transition-all rounded-lg w-full">
                            Log In
                        </button>
                    </form>

                    <script>
                        // Optional: Toggle password visibility
                        document.getElementById('toggle-password').addEventListener('click', function() {
                            var passwordField = document.querySelector('input[name="password"]');
                            var type = passwordField.type === 'password' ? 'text' : 'password';
                            passwordField.type = type;
                        });
                    </script>

                    <p class="text-bgray-600 dark:text-white text-center text-sm mt-6">
                        @ 2024 RCV Technologies All Right Reserved.
                    </p>
                </div>
            </div>
            <!-- Right -->
            <div class="lg:w-1/2 lg:block hidden bg-[#F6FAFF] dark:bg-slate-900 p-20 relative">
                <ul>
                    <li class="absolute top-10 left-8">
                        <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#e0f2fe"
                                stroke-width="2" />
                            <circle cx="60" cy="60" r="40" fill="none" stroke="#bae6fd"
                                stroke-width="2" stroke-dasharray="5,5" />
                            <circle cx="60" cy="60" r="30" fill="none" stroke="#7dd3fc"
                                stroke-width="2" />

                            <!-- Skills icons -->
                            <rect x="45" y="30" width="30" height="5" rx="2" fill="#3498db" />
                            <rect x="40" y="40" width="40" height="5" rx="2" fill="#2563eb" />
                            <rect x="35" y="50" width="50" height="5" rx="2" fill="#3498db" />
                            <rect x="42" y="60" width="36" height="5" rx="2" fill="#2563eb" />
                            <rect x="50" y="70" width="20" height="5" rx="2" fill="#3498db" />
                            <rect x="45" y="80" width="30" height="5" rx="2" fill="#2563eb" />
                        </svg>
                    </li>
                    <li class="absolute right-12 top-14">
                        <svg viewBox="0 0 20 100" xmlns="http://www.w3.org/2000/svg">
                            <line x1="10" y1="10" x2="10" y2="90" stroke="#bae6fd"
                                stroke-width="3" />
                            <circle cx="10" cy="10" r="5" fill="#3498db" />
                            <circle cx="10" cy="90" r="5" fill="#2563eb" />
                            <circle cx="10" cy="50" r="3" fill="#7dd3fc" />
                            <circle cx="10" cy="30" r="3" fill="#7dd3fc" />
                            <circle cx="10" cy="70" r="3" fill="#7dd3fc" />
                        </svg>
                    </li>
                    <li class="absolute bottom-7 left-8">
                        <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#bae6fd">
                                <circle cx="10" cy="10" r="3" />
                                <circle cx="30" cy="10" r="3" />
                                <circle cx="50" cy="10" r="3" />
                                <circle cx="70" cy="10" r="3" />
                                <circle cx="90" cy="10" r="3" />
                                <circle cx="110" cy="10" r="3" />

                                <circle cx="10" cy="30" r="3" />
                                <circle cx="30" cy="30" r="3" />
                                <circle cx="50" cy="30" r="3" />
                                <circle cx="70" cy="30" r="3" />
                                <circle cx="90" cy="30" r="3" />
                                <circle cx="110" cy="30" r="3" />

                                <circle cx="10" cy="50" r="3" />
                                <circle cx="30" cy="50" r="3" />
                                <circle cx="50" cy="50" r="3" />
                                <circle cx="70" cy="50" r="3" />
                                <circle cx="90" cy="50" r="3" />
                                <circle cx="110" cy="50" r="3" />

                                <circle cx="10" cy="70" r="3" />
                                <circle cx="30" cy="70" r="3" />
                                <circle cx="50" cy="70" r="3" />
                                <circle cx="70" cy="70" r="3" />
                                <circle cx="90" cy="70" r="3" />
                                <circle cx="110" cy="70" r="3" />

                                <circle cx="10" cy="90" r="3" />
                                <circle cx="30" cy="90" r="3" />
                                <circle cx="50" cy="90" r="3" />
                                <circle cx="70" cy="90" r="3" />
                                <circle cx="90" cy="90" r="3" />
                                <circle cx="110" cy="90" r="3" />

                                <circle cx="10" cy="110" r="3" />
                                <circle cx="30" cy="110" r="3" />
                                <circle cx="50" cy="110" r="3" />
                                <circle cx="70" cy="110" r="3" />
                                <circle cx="90" cy="110" r="3" />
                                <circle cx="110" cy="110" r="3" />
                            </g>
                        </svg>
                    </li>
                </ul>
                <div class="">
                    <svg viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background elements -->
                        <rect x="100" y="100" width="600" height="400" rx="20" fill="#f0f9ff" />

                        <!-- Stylized computer/device -->
                        <rect x="250" y="200" width="300" height="200" rx="10" fill="#ffffff"
                            stroke="#3498db" stroke-width="3" />
                        <rect x="270" y="220" width="260" height="140" rx="5" fill="#e0f2fe" />

                        <!-- Base of device -->
                        <path d="M350 400 L450 400 L470 440 L330 440 Z" fill="#2563eb" />

                        <!-- Login form on screen -->
                        <rect x="300" y="240" width="200" height="30" rx="5" fill="white"
                            stroke="#7dd3fc" stroke-width="2" />
                        <rect x="300" y="280" width="200" height="30" rx="5" fill="white"
                            stroke="#7dd3fc" stroke-width="2" />
                        <rect x="340" y="320" width="120" height="30" rx="15" fill="#2563eb" />

                        <!-- Stylized person -->
                        <circle cx="570" cy="260" r="40" fill="#bae6fd" />
                        <path d="M550 310 C550 310, 550 350, 590 350 C630 350, 630 310, 630 310" fill="none"
                            stroke="#3498db" stroke-width="3" />

                        <!-- Abstract recruitment elements -->
                        <rect x="160" y="220" width="60" height="10" rx="5" fill="#3498db" />
                        <rect x="160" y="240" width="50" height="10" rx="5" fill="#7dd3fc" />
                        <rect x="160" y="260" width="70" height="10" rx="5" fill="#3498db" />

                        <circle cx="180" cy="300" r="20" fill="none" stroke="#2563eb"
                            stroke-width="2" />
                        <circle cx="180" cy="350" r="20" fill="none" stroke="#2563eb"
                            stroke-width="2" />
                        <circle cx="180" cy="400" r="20" fill="none" stroke="#2563eb"
                            stroke-width="2" />

                        <line x1="200" y1="300" x2="230" y2="300" stroke="#bae6fd"
                            stroke-width="2" />
                        <line x1="200" y1="350" x2="230" y2="350" stroke="#bae6fd"
                            stroke-width="2" />
                        <line x1="200" y1="400" x2="230" y2="400" stroke="#bae6fd"
                            stroke-width="2" />

                        <!-- Connecting lines representing recruitment process -->
                        <path d="M620 340 C680 340, 680 380, 620 380" fill="none" stroke="#3498db"
                            stroke-width="2" stroke-dasharray="5,5" />
                        <path d="M600 400 C520 440, 440 440, 360 400" fill="none" stroke="#3498db"
                            stroke-width="2" />

                        <!-- Small icons representing hiring process -->
                        <circle cx="640" cy="180" r="15" fill="#3498db" />
                        <circle cx="680" cy="220" r="15" fill="#7dd3fc" />
                        <circle cx="700" cy="270" r="15" fill="#2563eb" />
                        <line x1="640" y1="180" x2="680" y2="220" stroke="#bae6fd"
                            stroke-width="2" />
                        <line x1="680" y1="220" x2="700" y2="270" stroke="#bae6fd"
                            stroke-width="2" />
                    </svg>
                </div>
                <div>
                    <div class="text-center max-w-lg px-1.5 m-auto">
                        <h3 class="text-bgray-900 dark:text-white font-semibold font-popins text-4xl mb-4">
                            Swift, Simple, and Efficient Hiring
                        </h3>
                        <p class="text-bgray-600 dark:text-white text-sm font-medium">
                            Empower your recruitment process with tools to streamline hiring, connect with top talent,
                            and achieve recruitment goals faster. Unlock exclusive features with your first successful
                            hire!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>

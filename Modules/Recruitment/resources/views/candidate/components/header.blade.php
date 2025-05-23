{{-- <nav
    class="bg-primary-500  shadow-lg p-4 flex flex-col md:flex-row items-center rounded-lg justify-between mb-4 top-0 left-0 z-50">
    <div class="flex items-center justify-between w-full md:w-auto mb-4 md:mb-0">
        <div class="flex items-center space-x-8">
            <a href="{{ route('candidate.dashboard') }}">
                <img src="{{ asset('images/logo/logo-color.png') }}" class="h-12 w-auto" alt="Logo" />
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('landing') }}" target="_blank" class="text-white hover:text-black">About Us</a>
                <a href="{{ route('candidate.dashboard') }}" class="text-white hover:text-black">Find
                    job</a>
                <!-- <a href="#" class="text-white hover:text-black">Messages</a> -->
                <a href="{{ route('candidate.applications.index') }}" class="text-white hover:text-black">My
                    Applications</a>

                <a href="{{ route('candidate.placement.index') }}" class="text-white hover:text-black">Placement
                    Drives</a>

                <!-- <a href="/candidate/mcq/signin/{{ encrypt(12) }}" class="text-white hover:text-black">Take Test</a> -->

                <a href="{{ route('candidate.faq') }}" class="text-white hover:text-black">FAQ</a>
            </div>
        </div>
        <!-- Add Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div> --}}
    {{-- <div class="flex items-center space-x-4">
        <!-- Welcome Message -->
        @if (auth()->guard('candidate')->check())
            <span class="text-white">Welcome, {{ auth()->guard('candidate')->user()->name }}</span>
        @else
            <span class="text-white">Welcome, Guest</span>
        @endif


        <!-- Theme toggle -->
        <div class="flex items-center">
            <button id="theme-toggle"
                class="relative inline-flex h-9 w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition-colors duration-300 focus:outline-none">
                <!-- Light Mode Icon -->
                <span
                    class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white text-gray-900 transition-transform duration-300 transform dark:translate-x-7">
                    <svg class="h-4 w-4 dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon -->
                    <svg class="hidden h-4 w-4 dark:block" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </span>
            </button>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button id="profileMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                <div
                    class="relative w-10 h-10 overflow-hidden bg-primary-600 rounded-full hover:ring-4 hover:ring-primary-400 transition duration-200">
                    <svg class="absolute w-12 h-12 text-white -left-1" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" />
                    </svg>
                </div>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 shadow-lg rounded-lg py-2 z-50">
                <a href="{{ route('candidate.profile.index') }}"
                    class="flex items-center px-4 py-2 text-gray-700 dark:text-white hover:bg-gray-100 hover:text-primary-500 dark:hover:bg-gray-700 dark:hover:text-primary-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('candidate.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-red-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div> --}}



    <!-- Responsive Header Section -->
    {{-- <div class="flex items-center justify-between w-full">
        <!-- Welcome Message (Left) -->
        <div class="text-white text-medium truncate">
            @if (auth()->guard('candidate')->check())
                <span>Welcome, {{ auth()->guard('candidate')->user()->name }}</span>
            @else
                <span>Welcome, Guest</span>
            @endif
        </div>

        <!-- Right Section: Theme Toggle + Profile -->
        <div class="flex items-center space-x-4">
            <!-- Theme toggle -->
            <div class="flex items-center">
                <button id="theme-toggle"
                    class="relative inline-flex h-9 w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition-colors duration-300 focus:outline-none">
                    <span
                        class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white text-gray-900 transition-transform duration-300 transform dark:translate-x-7">
                        <!-- Light Mode Icon -->
                        <svg class="h-4 w-4 dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon -->
                        <svg class="hidden h-4 w-4 dark:block" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                    <div
                        class="relative w-10 h-10 overflow-hidden bg-primary-600 rounded-full hover:ring-4 hover:ring-primary-400 transition duration-200">
                        <svg class="absolute w-12 h-12 text-white -left-1" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" />
                        </svg>
                    </div>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="profileDropdown"
                    class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 shadow-lg rounded-lg py-2 z-50">
                    <a href="{{ route('candidate.profile.index') }}"
                        class="flex items-center px-4 py-2 text-gray-700 dark:text-white hover:bg-gray-100 hover:text-primary-500 dark:hover:bg-gray-700 dark:hover:text-primary-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('candidate.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-red-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</nav> --}}

<!-- <script>
    // Theme Toggle
    const themeToggleBtn = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;

    // Update theme toggle appearance
    function updateThemeToggle() {
        const toggle = document.querySelector('#theme-toggle span');
        if (htmlElement.classList.contains('dark')) {
            toggle.classList.add('translate-x-7');
        } else {
            toggle.classList.remove('translate-x-7');
        }
    }

    // Initialize theme toggle state
    updateThemeToggle();

    themeToggleBtn.addEventListener('click', function() {
        if (htmlElement.classList.contains('dark')) {
            htmlElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            htmlElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
        updateThemeToggle();
    });

    // Profile Dropdown Toggle
    const profileMenuBtn = document.getElementById('profileMenuBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileMenuBtn.addEventListener('click', function() {
        profileDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!profileMenuBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
</script> -->

<nav class="bg-primary-500 shadow-lg p-4 rounded-lg mb-4 top-0 left-0 z-50">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-y-4">
        <!-- Left Section: Logo + Navigation -->
        <div class="flex flex-col md:flex-row md:items-center md:space-x-8 w-full md:w-auto">
            <div class="flex items-center justify-between w-full md:w-auto">
                <a href="{{ route('candidate.dashboard') }}">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="h-12 w-auto" alt="Logo" />
                </a>
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <!-- Menu Links (hidden on mobile) -->
            <div class="hidden md:flex space-x-6 mt-4 md:mt-0">
                <a href="{{ route('landing') }}" target="_blank" class="text-white hover:text-black">About Us</a>
                <a href="{{ route('candidate.dashboard') }}" class="text-white hover:text-black">Find job</a>
                <a href="{{ route('candidate.applications.index') }}" class="text-white hover:text-black">My Applications</a>
                <a href="{{ route('candidate.placement.index') }}" class="text-white hover:text-black">Placement Drives</a>
                <a href="{{ route('candidate.faq') }}" class="text-white hover:text-black">FAQ</a>
            </div>
        </div>

        <!-- Right Section: Welcome, Toggle, Profile -->
        <div class="flex items-center justify-between md:space-x-8 w-full md:w-auto">
            <!-- Welcome Message -->
            <div class="text-white truncate text-sm md:text-base">
                @if (auth()->guard('candidate')->check())
                    <span>Welcome, {{ auth()->guard('candidate')->user()->name }}</span>
                @else
                    <span>Welcome, Guest</span>
                @endif
            </div>

            <!-- Theme Toggle + Profile -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button id="theme-toggle"
                    class="relative inline-flex h-9 w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition-colors duration-300 focus:outline-none">
                    <span
                        class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white text-gray-900 transition-transform duration-300 transform dark:translate-x-7">
                        <svg class="h-4 w-4 dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="hidden h-4 w-4 dark:block" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                        <div
                            class="relative w-10 h-10 overflow-hidden bg-primary-600 rounded-full hover:ring-4 hover:ring-primary-400 transition duration-200">
                            <svg class="absolute w-12 h-12 text-white -left-1" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" />
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 shadow-lg rounded-lg py-2 z-50">
                        <a href="{{ route('candidate.profile.index') }}"
                            class="flex items-center px-4 py-2 text-gray-700 dark:text-white hover:bg-gray-100 hover:text-primary-500 dark:hover:bg-gray-700 dark:hover:text-primary-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('candidate.logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-red-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

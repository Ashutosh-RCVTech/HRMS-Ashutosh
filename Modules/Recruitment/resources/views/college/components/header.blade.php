@php
    $placementData = collegeHavePlacement(auth()->guard('college')->user()->id);
@endphp

<nav
    class="bg-primary-500 shadow-lg p-4 md:p-5 flex flex-col md:flex-row items-center rounded-lg justify-between mb-4 mx-3 md:mx-0 top-0 left-0 z-50">
    <div class="flex items-center justify-between w-full md:w-auto mb-4 md:mb-0">
        <div class="flex items-center space-x-4 md:space-x-8">
            <a href="{{ route('college.dashboard') }}">
                <img src="{{ asset('images/logo/logo-color.png') }}" class="h-10 md:h-12 w-auto" alt="Logo" />
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('landing') }}" target="_blank" class="text-white hover:text-black">About Us</a>
                <a href="{{ route('college.dashboard') }}" class="text-white hover:text-black">Dashboard</a>
                <a href="{{ route('college.placement.detail') }}" class="text-white hover:text-black">Placement
                    Drives</a>
            </div>
        </div>
        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden w-full bg-primary-500 pb-3 -mt-2 mb-3 space-y-2">
        <a href="{{ route('landing') }}" target="_blank" class="block text-white hover:text-black py-2 px-2">About
            Us</a>
        <a href="{{ route('college.dashboard') }}" class="block text-white hover:text-black py-2 px-2">Dashboard</a>
        <a href="{{ route('college.placement.detail') }}" class="block text-white hover:text-black py-2 px-2">Placement
            Drives</a>
    </div>

    <div class="flex items-center space-x-3 md:space-x-4">
        <!-- Welcome Message -->
        <span class="text-white text-sm md:text-base truncate max-w-[120px] md:max-w-none">Welcome,
            {{ auth()->guard('college')->user()->name }}</span>

        <!-- Notification Bell -->
        <div class="relative" id="notification-container">
            <button class="text-white hover:text-black p-1 relative" id="notification-button">
                <!-- Bell Icon SVG with Badge -->
                <div class="relative">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <!-- Notification Counter -->
                    <span
                        class="absolute -top-2 -right-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-semibold">
                        {{ $placementData['count'] }}
                    </span>
                </div>
            </button>

            <!-- Notification Dropdown -->
            <div class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl z-50 border border-gray-100"
                id="notification-dropdown">
                <div class="p-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-900 font-semibold text-base">Notifications</h3>
                    </div>

                    <!-- Notification List -->
                    <div class="max-h-96 overflow-y-auto space-y-3">
                        @foreach ($placementData['latestRecords'] as $record)
                            <div class="group flex items-start p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="shrink-0 mt-1">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $record->name }}</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ \Illuminate\Support\Str::limit($record->description, 10) }}
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs text-blue-600 font-medium">
                                            {{ $record->created_at->diffForHumans() }}
                                        </span>
                                        <button
                                            class="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-gray-600 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('college.placement.detail') }}"
                            class="w-full block text-center px-4 py-2 bg-white hover:bg-gray-50 text-blue-600 font-medium rounded-lg border border-gray-200 transition-colors">
                            View All Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme toggle -->
        <div class="flex items-center">
            <button id="theme-toggle"
                class="relative inline-flex h-8 md:h-9 w-14 md:w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition-colors duration-300 focus:outline-none">
                <!-- Light Mode Icon -->
                <span
                    class="absolute left-1 flex h-6 md:h-7 w-6 md:w-7 items-center justify-center rounded-full bg-white text-gray-900 transition-transform duration-300 transform dark:translate-x-7">
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
            <button id="profileMenuBtn" class="flex items-center space-x-1 md:space-x-2 focus:outline-none">
                <div
                    class="relative w-9 h-9 md:w-10 md:h-10 overflow-hidden bg-primary-600 rounded-full hover:ring-4 hover:ring-primary-400 transition duration-200">
                    <svg class="absolute w-11 h-11 md:w-12 md:h-12 text-white -left-1" fill="currentColor"
                        viewBox="0 0 24 24">
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
                <a href="{{ route('college.profile.show') }}"
                    class="flex items-center px-4 py-2 text-gray-700 dark:text-white hover:bg-gray-100 hover:text-primary-500 dark:hover:bg-gray-700 dark:hover:text-primary-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('college.logout') }}">
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
</nav>

<script>
    // Notification Dropdown
    const container = document.getElementById('notification-container');
    const button = document.getElementById('notification-button');
    const dropdown = document.getElementById('notification-dropdown');

    button.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!container.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

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

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
</script>

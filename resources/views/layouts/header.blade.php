<!-- Desktop Header -->

<header class="header-wrapper bg-white dark:bg-slate-900 fixed z-30 hidden w-full md:block">
    <!-- Sidebar Toggle Button - Positioned more to the left -->
    <div class="absolute left-[-35px] top-1/2 transform -translate-y-1/2">
        <button title="Toggle Sidebar (Ctrl+b)" type="button" id="sidebar-toggle"
            class="drawer-btn flex items-center justify-center h-10 w-10 md:h-12 md:w-12 hover:bg-gray-100 rounded-lg transition-all duration-300 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-[#bf125d] focus:ring-opacity-50">
            <span class="transform transition-transform duration-300">
                <svg width="16" height="40" viewBox="0 0 16 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z" fill="#bf125d" />
                    <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>
        </button>
    </div>
    <div
        class="relative flex min-h-[108px] w-full max-w-7xl mx-auto items-center justify-between bg-white shadow-sm dark:bg-slate-900 px-4 lg:px-6">

        <!-- Enhanced Search Bar -->
        <div class="searchbar-wrapper mx-4 relative flex-1 max-w-3xl">
            <div
                class="flex h-[56px] w-full items-center justify-between rounded-xl border border-transparent bg-gray-50 px-4 focus-within:border-[#bf125d] focus-within:shadow-lg transition-all duration-300 dark:bg-slate-800">
                <div class="flex w-full items-center space-x-3.5">
                    <span class="text-[#bf125d] transition-colors duration-300">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9.78639" cy="9.78602" r="8.23951" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15.5176 15.9447L18.7479 19.1667" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <div class="relative flex-1">
                        <input type="text" id="global-search" placeholder="Search for jobs, candidates, colleges..."
                            class="w-full border-none bg-gray-50 dark:bg-slate-800 px-0 text-sm tracking-wide text-gray-600 dark:text-gray-300 placeholder:text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-0" />

                        <!-- Search Results Dropdown -->
                        <div id="search-results"
                            class="absolute left-0 right-0 top-full mt-2 hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-slate-800 z-[999] w-[500px]">
                            <!-- Categories -->
                            <div class="p-2">
                                <div
                                    class="flex items-center space-x-2 px-3 py-2 text-xs font-semibold text-gray-400 dark:text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    <span>CATEGORIES</span>
                                </div>
                                <div class="space-y-1">
                                    <a href="{{ route('admin.jobs.index') }}"
                                        class="flex w-full items-center space-x-3 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </span>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200">Jobs</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Search job
                                                listings</span>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.candidates.index') }}"
                                        class="flex w-full items-center space-x-3 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </span>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200">Candidates</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Search
                                                candidates</span>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.colleges.index') }}"
                                        class="flex w-full items-center space-x-3 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z">
                                                </path>
                                            </svg>
                                        </span>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200">Colleges</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Search
                                                colleges</span>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Quick Links -->
                            <div class="border-t border-gray-100 p-2 dark:border-gray-700">
                                <div
                                    class="flex items-center space-x-2 px-3 py-2 text-xs font-semibold text-gray-400 dark:text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>QUICK LINKS</span>
                                </div>
                                <div class="space-y-1">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center space-x-3 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <span class="text-[#bf125d]">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Dashboard</span>
                                    </a>
                                    <a href="{{ route('admin.settings') }}"
                                        class="flex items-center space-x-3 rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <span class="text-[#bf125d]">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Settings</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search Shortcut Badge -->
                    <span
                        class="hidden sm:flex items-center rounded-md border border-gray-200 bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-400 dark:border-gray-700 dark:bg-gray-800">
                        <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Ctrl + K
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="quick-access-wrapper relative flex items-center space-x-4 lg:space-x-6">
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

            <!-- Notification Icon -->
            <div class="relative">
                <button type="button" id="notification-toggle"
                    class="relative flex h-[40px] w-[40px] items-center justify-center rounded-xl border border-[#bf125d] hover:bg-[#bf125d] hover:text-white transition-all duration-300 dark:border-darkblack-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if ($unreadCount = Auth::user()->unreadNotifications->count())
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div id="notification-dropdown"
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            @if ($unreadCount > 0)
                                <form action="{{ route('admin.notifications.markAllAsRead') }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-[#bf125d] hover:text-[#a01050]">
                                        Mark all as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="max-h-96 overflow-y-auto">
                        @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                            <div
                                class="p-4 border-b border-gray-200 dark:border-gray-700 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900 dark:text-white">
                                            {{ $notification->data['message'] ?? 'New notification' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if (!$notification->read_at)
                                            <form
                                                action="{{ route('admin.notifications.markAsRead', $notification->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-[#bf125d] hover:text-[#a01050]">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                No notifications
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.notifications') }}"
                            class="block text-center text-sm text-[#bf125d] hover:text-[#a01050]">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Profile Section -->
            <div class="flex cursor-pointer items-center space-x-3 profile-trigger group"
                onclick="toggleProfileMenu()">
                <div
                    class="h-10 w-10 md:h-12 md:w-12 overflow-hidden rounded-xl border-2 border-[#bf125d] transition-transform duration-300 group-hover:scale-105">
                    <img class="object-cover w-full h-full" src="{{ asset('images/avatar/profile.png') }}"
                        alt="avatar" />
                </div>
                <div class="hidden xl:block">
                    <div class="flex items-center space-x-2.5">
                        <h3 class="text-base font-bold leading-[28px] text-bgray-900 dark:text-white">
                            {{ Auth::user()->name }}
                        </h3>
                        <span class="transition-transform duration-300 group-hover:translate-y-1">
                            <svg class="stroke-bgray-900 dark:stroke-white" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 10L12 14L17 10" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-sm font-medium leading-[20px] text-bgray-600 dark:text-bgray-50">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Enhanced Profile Dropdown -->
        {{-- <div class="profile-wrapper">
            <div class="profile-outside fixed inset-0 hidden h-full w-full bg-black/20 backdrop-blur-sm dark:bg-black/40"
                onclick="toggleProfileMenu()"></div>
            <div
                class="profile-box absolute right-[-4px] top-[81px] hidden w-[300px] transform overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg transition-all duration-300 dark:border-gray-700 dark:bg-slate-900">
                <div class="relative w-full px-3 py-2">
                    <div>
                        <ul class="space-y-1">
                            <!-- Profile Header -->
                            <li class="w-full">
                                <div
                                    class="flex items-center space-x-3 p-3 border-b border-gray-100 dark:border-gray-800">
                                    <div class="h-12 w-12 overflow-hidden rounded-xl border-2 border-[#bf125d]">
                                        <img class="object-cover w-full h-full"
                                            src="{{ asset('images/avatar/profile.png') }}"
                                            alt="avatar" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ Auth::user()->name }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <!-- Profile Options -->
                            <li>
                                <a href="{{ route('admin.profile.edit') }}"
                                    class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                    <span class="text-[#bf125d]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium">My Profile</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.settings') }}"
                                    class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                    <span class="text-[#bf125d]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium">Settings</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.notifications') }}"
                                    class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                    <span class="text-[#bf125d]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium">Notifications</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.help') }}"
                                    class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                    <span class="text-[#bf125d]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium">Help & Support</span>
                                </a>
                            </li>

                            <!-- Logout Button -->
                            <li class="w-full">
                                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full space-x-3 p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200">
                                        <span class="text-[#bf125d]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </span>
                                        <span class="text-sm font-medium">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</header>

<!-- Mobile Header -->
<header class="mobile-wrapper fixed z-20 block w-full md:hidden">
    <div class="flex h-[60px] w-full items-center justify-between bg-white shadow-sm dark:bg-slate-900 px-4">
        <div class="flex h-full items-center space-x-5">
            <button type="button" id="mobile-sidebar-toggle"
                class="drawer-btn flex items-center justify-center h-10 w-10 hover:bg-gray-100 rounded-lg transition-all duration-300 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-[#bf125d] focus:ring-opacity-50">
                <span class="transform transition-transform duration-300">
                    <svg width="16" height="40" viewBox="0 0 16 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z"
                            fill="#bf125d" />
                        <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
            <div class="max-w-[120px] sm:max-w-[150px]">
                <a href="/" class="block">
                    <img src="{{ asset('images/logo/logo-color.png') }}" class="block dark:hidden h-8 w-auto"
                        alt="logo" />
                    <img src="{{ asset('images/logo/logo-white.png') }}" class="hidden dark:block h-8 w-auto"
                        alt="logo" />
                </a>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Theme Toggle for Mobile -->
            <button id="mobile-theme-toggle"
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

            <!-- Profile Trigger for Mobile -->
            <div class="h-[40px] w-[40px] overflow-hidden rounded-xl border-2 border-[#bf125d] cursor-pointer profile-trigger transition-transform duration-300 hover:scale-105"
                onclick="toggleProfileMenu(event)">
                <img class="object-cover w-full h-full" src="#" alt="avatar">
            </div>
        </div>
    </div>
</header>

<!-- Profile Dropdown (Shared between mobile and desktop) -->
<div class="profile-wrapper">
    <div class="profile-outside fixed inset-0 hidden h-full w-full bg-black/20 backdrop-blur-sm dark:bg-black/40 z-40"
        onclick="toggleProfileMenu()"></div>
    <div
        class="profile-box fixed right-4 top-16 hidden w-[300px] transform overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg transition-all duration-300 dark:border-gray-700 dark:bg-slate-900 z-50 md:absolute md:right-6 md:top-[81px]">
        <div class="relative w-full px-3 py-2">
            <div>
                <ul class="space-y-1">
                    <!-- Profile Header -->
                    <li class="w-full">
                        <div class="flex items-center space-x-3 p-3 border-b border-gray-100 dark:border-gray-800">
                            <div class="h-12 w-12 overflow-hidden rounded-xl border-2 border-[#bf125d]">
                                <img class="object-cover w-full h-full"
                                    src="{{ asset('images/avatar/profile.png') }}" alt="avatar" />
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ Auth::user()->name }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <!-- Profile Options -->
                    <li>
                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <span class="text-[#bf125d]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">My Profile</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <span class="text-[#bf125d]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.notifications') }}"
                            class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <span class="text-[#bf125d]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Notifications</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.help') }}"
                            class="flex items-center space-x-3 p-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <span class="text-[#bf125d]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Help & Support</span>
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li class="w-full">
                        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full space-x-3 p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200">
                                <span class="text-[#bf125d]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </span>
                                <span class="text-sm font-medium">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize state
        // Initialize state variables
        let isSidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
        let isNotificationMenuOpen = false; // Explicitly declare this variable
        let isProfileMenuOpen = false; // Add a flag for profile menu

        const sidebar = document.querySelector('aside');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const toggleButtons = [sidebarToggle, mobileSidebarToggle];
        const profileBox = document.querySelector('.profile-box');
        const profileOutside = document.querySelector('.profile-outside');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationToggle = document.getElementById('notification-toggle');
        const profileTriggers = document.querySelectorAll('.profile-trigger');

        // Function to update sidebar state
        function updateSidebarState(open) {
            isSidebarOpen = open;
            localStorage.setItem('sidebarOpen', open);

            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full', !open);
            }

            // Update toggle buttons
            toggleButtons.forEach(button => {
                if (button) {
                    const icon = button.querySelector('span');
                    if (icon) {
                        icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }
            });
        }

        // Function to toggle sidebar
        function toggleSidebar() {
            updateSidebarState(!isSidebarOpen);
        }

        // Function to toggle profile menu
        function toggleProfileMenu(event) {
            if (event) {
                event.stopPropagation();
            }

            // Toggle profile menu state
            isProfileMenuOpen = !isProfileMenuOpen;

            if (profileBox && profileOutside) {
                // Toggle visibility of profile menu
                profileBox.classList.toggle('hidden');
                profileOutside.classList.toggle('hidden');

                // Close other menus
                if (isNotificationMenuOpen && notificationDropdown) {
                    isNotificationMenuOpen = false;
                    notificationDropdown.classList.add('hidden');
                }
            }
        }

        // Function to toggle notification dropdown
        function toggleNotificationDropdown(event) {
            if (event) {
                event.stopPropagation();
            }

            if (notificationDropdown) {
                isNotificationMenuOpen = !isNotificationMenuOpen;
                notificationDropdown.classList.toggle('hidden');

                // Close profile menu if open
                if (isSidebarOpen) {
                    isSidebarOpen = false;
                    localStorage.setItem('sidebarOpen', false);
                    profileBox.classList.add('hidden');
                    profileOutside.classList.add('hidden');
                }
            }
        }

        // Add click event listeners
        toggleButtons.forEach(button => {
            if (button) {
                button.addEventListener('click', toggleSidebar);
            }
        });

        if (notificationToggle) {
            notificationToggle.addEventListener('click', toggleNotificationDropdown);
        }


        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const profileTriggers = document.querySelectorAll('.profile-trigger');
            let clickedInsideTrigger = false;

            profileTriggers.forEach(trigger => {
                if (trigger?.contains(event.target)) {
                    clickedInsideTrigger = true;
                }
            });

            if (isSidebarOpen && profileBox && !clickedInsideTrigger && !profileBox.contains(event
                    .target)) {
                isSidebarOpen = false;
                localStorage.setItem('sidebarOpen', false);
                profileBox.classList.add('hidden');
                profileOutside.classList.add('hidden');
            }

            if (isNotificationMenuOpen && notificationDropdown && !notificationToggle.contains(event
                    .target) && !notificationDropdown.contains(event.target)) {
                isNotificationMenuOpen = false;
                notificationDropdown.classList.add('hidden');
            }
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const mobileThemeToggle = document.getElementById('mobile-theme-toggle');

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
        }

        if (themeToggle) {
            const darkMode = localStorage.getItem('darkMode') === 'true';
            document.documentElement.classList.toggle('dark', darkMode);
            themeToggle.addEventListener('click', toggleTheme);
        }

        if (mobileThemeToggle) {
            mobileThemeToggle.addEventListener('click', toggleTheme);
        }

        // Keyboard shortcut for sidebar toggle (Ctrl+b)
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 'b') {
                event.preventDefault();
                toggleSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // md breakpoint
                updateSidebarState(true);
            }
        });

        // Make function globally available
        window.toggleSidebar = toggleSidebar;
        window.toggleProfileMenu = toggleProfileMenu;

        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;

        // Show/hide search results
        searchInput.addEventListener('focus', () => {
            searchResults.classList.remove('hidden');
        });

        // Handle click outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // Handle keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Ctrl + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }

            // Escape to close search results
            if (e.key === 'Escape') {
                searchResults.classList.add('hidden');
                searchInput.blur();
            }
        });

        // Handle search input
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            const query = e.target.value;

            searchTimeout = setTimeout(() => {
                if (query.length >= 2) {
                    // Make AJAX call to search endpoint
                    fetch(`/admin/search?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Update search results
                            updateSearchResults(data);
                        })
                        .catch(error => console.error('Error:', error));
                }
            }, 300);
        });

        function updateSearchResults(data) {
            const resultsContainer = document.getElementById('search-results');
            const categories = ['jobs', 'candidates', 'colleges', 'clients', 'applications'];
            let hasResults = false;

            // Clear previous results
            const dynamicResults = resultsContainer.querySelector('.dynamic-results');
            if (dynamicResults) {
                dynamicResults.remove();
            }

            // Create new results section
            const resultsSection = document.createElement('div');
            resultsSection.className = 'dynamic-results border-t border-gray-100 dark:border-gray-700';

            // Process each category
            categories.forEach(category => {
                if (data.results[category] && data.results[category].length > 0) {
                    hasResults = true;

                    // Add category header
                    const categoryHeader = document.createElement('div');
                    categoryHeader.className =
                        'flex items-center space-x-2 px-3 py-2 text-xs font-semibold text-gray-400 dark:text-gray-500';
                    categoryHeader.innerHTML = `
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span>${category.toUpperCase()}</span>
                    `;
                    resultsSection.appendChild(categoryHeader);

                    // Add results
                    const resultsDiv = document.createElement('div');
                    resultsDiv.className = 'space-y-1 mb-3';

                    data.results[category].forEach(result => {
                        const resultItem = document.createElement('a');
                        resultItem.href = result.url;
                        resultItem.className =
                            'flex items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg';

                        // Get appropriate icon based on result type
                        const icon = getIconForType(result.type);

                        resultItem.innerHTML = `
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-${getColorForType(result.type)}-50 text-${getColorForType(result.type)}-600 dark:bg-${getColorForType(result.type)}-900/30 dark:text-${getColorForType(result.type)}-400">
                                ${icon}
                            </span>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">${result.title}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">${result.subtitle}</span>
                            </div>
                        `;

                        resultsDiv.appendChild(resultItem);
                    });

                    resultsSection.appendChild(resultsDiv);
                }
            });

            // Show no results message if needed
            if (!hasResults) {
                const noResults = document.createElement('div');
                noResults.className = 'p-4 text-center text-gray-500 dark:text-gray-400';
                noResults.textContent = 'No results found';
                resultsSection.appendChild(noResults);
            }

            // Add the results section to the container
            resultsContainer.appendChild(resultsSection);
        }

        function getColorForType(type) {
            const colors = {
                job: 'indigo',
                candidate: 'green',
                college: 'purple',
                client: 'blue',
                application: 'pink'
            };
            return colors[type] || 'gray';
        }

        function getIconForType(type) {
            const icons = {
                job: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                candidate: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                college: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>',
                client: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
                application: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'
            };
            return icons[type] || icons.job;
        }
    });
</script>

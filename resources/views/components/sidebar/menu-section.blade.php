<div>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden">
    </div>

    {{-- Sidebar --}}
    <aside x-bind:class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
        class="fixed inset-y-0 left-0 z-30 w-70 transition-transform duration-300 transform 
                 bg-white dark:bg-slate-900 border-r border-gray-200 dark:border-gray-800 
                 lg:translate-x-0 lg:static lg:inset-0 shadow-lg flex flex-col h-screen">

        {{-- Sidebar Header --}}
        <div
            class="flex-shrink-0 flex items-center justify-between h-[109px] px-4 pr-24 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center space-x-2">
                <x-sidebar.logo />
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Admin</h2>
            </div>

            {{-- Mobile close button --}}
            <button type="button" class="drawer-btn absolute right-0 top-auto" title="Ctrl+b">
                <span>
                    <svg width="16" height="40" viewBox="0 0 16 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z"
                            fill="#bf125d" />
                        <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
        </div>

        {{-- Sidebar Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Scrollable Navigation Area --}}
            <div
                class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent">
                <div class="flex flex-col space-y-1 p-4">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Recruitment Section -->
                    <div class="space-y-1">
                        <div
                            class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Recruitment
                        </div>

                        <!-- Colleges -->
                        <a href="{{ route('admin.colleges.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.colleges.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Colleges</span>
                        </a>

                        <!-- Candidates -->
                        <a href="{{ route('admin.candidates.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.candidates.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Candidates</span>
                        </a>

                        <!-- Placement Drives -->
                        <a href="{{ route('admin.placement.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.drives.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Placement Drives</span>
                        </a>

                        <!-- Job Applications -->
                        <a href="{{ route('admin.job-applications.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.job-applications.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Job Applications</span>
                        </a>

                        <!-- Enquiries -->
                        <a href="{{ route('admin.contacts.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Enquiries</span>
                        </a>
                    </div>

                    <!-- Master Data Section -->
                    <div class="space-y-1">
                        <div
                            class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Master Data
                        </div>

                        <!-- Clients -->
                        <a href="{{ route('admin.clients.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.clients.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Clients</span>
                        </a>

                        <!-- Jobs -->
                        <a href="{{ route('admin.jobs.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.jobs.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Jobs</span>
                        </a>

                        <!-- Skills -->
                        <a href="{{ route('admin.skills.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.skills.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <span>Skills</span>
                        </a>

                        <!-- Education Levels -->
                        <a href="{{ route('admin.educationLevels.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.educationLevels.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            <span>Education Levels</span>
                        </a>

                        <!-- Benefits -->
                        <a href="{{ route('admin.benefits.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.benefits.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Benefits</span>
                        </a>

                        <!-- Job Types -->
                        <a href="{{ route('admin.jobTypes.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.jobTypes.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Job Types</span>
                        </a>

                        <!-- Schedules -->
                        <a href="{{ route('admin.schedules.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.schedules.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Schedules</span>
                        </a>

                        <!-- Degrees -->
                        <a href="{{ route('admin.degrees.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.degrees.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span>Degrees</span>
                        </a>

                        <!-- Locations -->
                        <a href="{{ route('admin.locations.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.locations.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Locations</span>
                        </a>

                        <!-- Quizes -->
                        <a href="{{ route('admin.quiz.courses.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.quiz.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6" />
                                <circle cx="6" cy="12" r="1" fill="currentColor" />
                                <circle cx="6" cy="16" r="1" fill="currentColor" />
                            </svg>
                            <span>Quiz</span>
                        </a>


                        <!-- Quiz Assignments -->
                        {{-- <a href="{{ route('admin.quiz.quizes.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.quiz.quizes.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6" />
                                <circle cx="6" cy="12" r="1" fill="currentColor" />
                                <circle cx="6" cy="16" r="1" fill="currentColor" />
                            </svg>
                            <span>Quiz Assignments</span>
                        </a> --}}

                        <!-- Test Monitoring (New) -->
                        <a href="{{ route('admin.quiz.monitoring.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.quiz.monitoring.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Test Monitoring</span>
                        </a>
                    </div>

                    <!-- Settings Section -->
                    <div class="space-y-1">
                        <div
                            class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Settings
                        </div>

                        <!-- Roles & Permissions -->
                        <a href="{{ route('admin.roles.index') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Roles & Permissions</span>
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.settings') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Settings</span>
                        </a>

                        <!-- Help & Support -->
                        <a href="{{ route('admin.help') }}"
                            class="flex items-center space-x-3 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.help') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Help & Support</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- User Profile Section --}}
            {{-- <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white">
                            <span class="text-sm font-bold">{{ auth()->user()->initials ?? 'A' }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ auth()->user()->name ?? 'Admin User' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ auth()->user()->email ?? 'admin@example.com' }}
                        </p>
                    </div>
                </div>
            </div> --}}

            {{-- Copyright Section --}}
            <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-800">
                <x-sidebar.copyright />
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex flex-col flex-1 overflow-x-hidden lg:ml-70">
        {{-- Main Content Area --}}
        {{-- <main class="flex-1 p-4 sm:p-6 overflow-y-auto bg-gray-50 dark:bg-slate-900">
            {{ $slot ?? '' }}
        </main> --}}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recruitmentMenuBtn = document.getElementById('recruitmentMenuBtn');
        const recruitmentSubmenu = document.getElementById('recruitmentSubmenu');
        const recruitmentMenuIcon = document.getElementById('recruitmentMenuIcon');

        // Check if there's a saved state in localStorage
        const isMenuOpen = localStorage.getItem('recruitmentMenuOpen') === 'true';
        if (isMenuOpen) {
            recruitmentSubmenu.classList.remove('hidden');
            recruitmentMenuIcon.style.transform = 'rotate(180deg)';
        }

        recruitmentMenuBtn.addEventListener('click', function() {
            const isHidden = recruitmentSubmenu.classList.contains('hidden');

            // Toggle the submenu
            recruitmentSubmenu.classList.toggle('hidden');

            // Rotate the icon
            recruitmentMenuIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0)';

            // Save the state to localStorage
            localStorage.setItem('recruitmentMenuOpen', !isHidden);
        });

        // Check if current page is in the submenu
        const currentPath = window.location.pathname;
        const submenuLinks = recruitmentSubmenu.querySelectorAll('a');
        let isCurrentPageInSubmenu = false;

        submenuLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                isCurrentPageInSubmenu = true;
                link.classList.add('bg-gray-100', 'dark:bg-gray-800');
            }
        });

        // If current page is in submenu, open the menu
        if (isCurrentPageInSubmenu) {
            recruitmentSubmenu.classList.remove('hidden');
            recruitmentMenuIcon.style.transform = 'rotate(180deg)';
            localStorage.setItem('recruitmentMenuOpen', 'true');
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                document.querySelector('aside').classList.remove('-translate-x-full');
            }
        });
    });
</script>

<div class="sidebar-body h-[calc(100vh-108px)] w-full overflow-y-auto overflow-x-visible relative z-[9999]">
    <div class="flex flex-col items-center py-4">
        <!-- Dashboard -->
        <div class="nav-item mb-2 relative">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-800 group" title="Dashboard">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-[#bf125d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
        </div>

        <!-- Recruitment Section -->
        <div class="nav-item mb-2 relative group">
            <button class="flex items-center justify-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-800 group" title="Recruitment">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-[#bf125d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </button>
            <!-- Submenu -->
            <div class="submenu hidden fixed left-[72px] w-48 bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 py-2 z-[60]">
                <div class="absolute -left-2 top-1/2 -translate-y-1/2">
                    <div class="w-2 h-2 rotate-45 bg-white dark:bg-slate-900 border-l border-t border-gray-200 dark:border-gray-800"></div>
                </div>
                <a href="{{ route('admin.colleges.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Colleges</a>
                <a href="{{ route('admin.candidates.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Candidates</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Placement Drives</a>
            </div>
        </div>

        <!-- Master Data Section -->
        <div class="nav-item mb-2 relative group">
            <button class="flex items-center justify-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-800 group" title="Master Data">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-[#bf125d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </button>
            <!-- Submenu -->
            <div class="submenu hidden fixed left-[72px] w-48 bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 py-2 z-[60]">
                <div class="absolute -left-2 top-1/2 -translate-y-1/2">
                    <div class="w-2 h-2 rotate-45 bg-white dark:bg-slate-900 border-l border-t border-gray-200 dark:border-gray-800"></div>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Clients</a>
                <a href="{{ route('admin.jobs.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Jobs</a>
                <a href="{{ route('admin.skills.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Skills</a>
                <a href="{{ route('admin.educationLevels.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Education Levels</a>
                <a href="{{ route('admin.benefits.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Benefits</a>
                <a href="{{ route('admin.jobTypes.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Job Types</a>
                <a href="{{ route('admin.schedules.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Schedules</a>
                <a href="{{ route('admin.degrees.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Degrees</a>
                <a href="{{ route('admin.locations.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Locations</a>
            </div>
        </div>

        <!-- Applications & Enquiries -->
        <div class="nav-item mb-2 relative group">
            <button class="flex items-center justify-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-800 group" title="Applications & Enquiries">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-[#bf125d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </button>
            <!-- Submenu -->
            <div class="submenu hidden fixed left-[72px] w-48 bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 py-2 z-[60]">
                <div class="absolute -left-2 top-1/2 -translate-y-1/2">
                    <div class="w-2 h-2 rotate-45 bg-white dark:bg-slate-900 border-l border-t border-gray-200 dark:border-gray-800"></div>
                </div>
                <a href="{{ route('admin.job-applications.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Job Applications</a>
                <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Enquiries</a>
            </div>
        </div>

        <!-- Settings -->
        <div class="nav-item mb-2 relative group">
            <button class="flex items-center justify-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-800 group" title="Settings">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-[#bf125d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
            <!-- Submenu -->
            <div class="submenu hidden fixed left-[72px] w-48 bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 py-2 z-[60]">
                <div class="absolute -left-2 top-1/2 -translate-y-1/2">
                    <div class="w-2 h-2 rotate-45 bg-white dark:bg-slate-900 border-l border-t border-gray-200 dark:border-gray-800"></div>
                </div>
                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Roles & Permissions</a>
                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Settings</a>
                <a href="{{ route('admin.help') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800">Help & Support</a>
            </div>
        </div>

        <!-- Logout -->
        <div class="nav-item mt-auto">
            <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex items-center justify-center p-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 group" title="Logout">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const button = item.querySelector('button');
            const submenu = item.querySelector('.submenu');
            
            if (button && submenu) {
                function positionSubmenu() {
                    const rect = item.getBoundingClientRect();
                    submenu.style.top = `${rect.top}px`;
                }

                if (submenu) {
                    positionSubmenu();
                }

                // Update position on scroll
                document.addEventListener('scroll', () => {
                    if (!submenu.classList.contains('hidden')) {
                        positionSubmenu();
                    }
                });
                
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Close all other submenus
                    document.querySelectorAll('.submenu').forEach(menu => {
                        if (menu !== submenu) {
                            menu.classList.add('hidden');
                        }
                    });
                    submenu.classList.toggle('hidden');
                    if (!submenu.classList.contains('hidden')) {
                        positionSubmenu();
                    }
                });

                // Add hover functionality for desktop
                if (window.innerWidth >= 768) {
                    item.addEventListener('mouseenter', function() {
                        // Close all other submenus first
                        document.querySelectorAll('.submenu').forEach(menu => {
                            if (menu !== submenu) {
                                menu.classList.add('hidden');
                            }
                        });
                        submenu.classList.remove('hidden');
                        positionSubmenu();
                    });

                    item.addEventListener('mouseleave', function(e) {
                        // Check if mouse is moving to submenu
                        const submenuRect = submenu.getBoundingClientRect();
                        if (
                            e.clientX < submenuRect.left ||
                            e.clientX > submenuRect.right ||
                            e.clientY < submenuRect.top ||
                            e.clientY > submenuRect.bottom
                        ) {
                            submenu.classList.add('hidden');
                        }
                    });

                    submenu.addEventListener('mouseleave', function() {
                        submenu.classList.add('hidden');
                    });
                }
            }
        });

        // Close submenus when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-item')) {
                document.querySelectorAll('.submenu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.add('hidden');
            });
        });
    });
</script>

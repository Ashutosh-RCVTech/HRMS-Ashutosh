<!-- Mobile Menu -->
<div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div
        class="bg-white dark:bg-slate-900 w-64 h-full transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-4">
            <div class="flex justify-between items-center mb-8">
                <img src="{{ asset('images/logo/logo-color.png') }}" class="h-8 dark:hidden" alt="Logo" />
                <img src="{{ asset('images/logo/logo-white.png') }}" class="h-8 hidden dark:block" alt="Logo" />
                <button id="close-mobile-menu"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="space-y-4">
                <a href="{{ route('college.dashboard') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('college.dashboard') ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    Dashboard
                </a>
                <a href="{{ route('college.drives.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('college.drives.*') ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    Placement Drives
                </a>

                <a href="#"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('college.organizations.*') ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    Hiring Organizations
                </a>
                <a href="{{ route('college.profile.show') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('college.profile.*') ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    Profile
                </a>
            </nav>

            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4 px-4">
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A4.992 4.992 0 0112 15c1.657 0 3.156.804 4.121 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ auth()->guard('college')->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ auth()->guard('college')->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('college.logout') }}" class="px-4">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 px-4 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-500 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition duration-200">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // // Mobile Menu Functionality
    // const mobileMenuToggleBtn = document.getElementById('mobileMenuBtn');
    // const mobileMenu = document.getElementById('mobile-menu');
    // const mobileMenuContent = mobileMenu.querySelector('div');
    // const closeMobileMenuBtn = document.getElementById('close-mobile-menu');

    // function openMobileMenu() {
    //     mobileMenu.classList.remove('hidden');
    //     setTimeout(() => {
    //         mobileMenuContent.classList.remove('-translate-x-full');
    //     }, 10);
    // }

    // function closeMobileMenu() {
    //     mobileMenuContent.classList.add('-translate-x-full');
    //     setTimeout(() => {
    //         mobileMenu.classList.add('hidden');
    //     }, 300);
    // }

    // // Toggle mobile menu when hamburger button is clicked
    // mobileMenuToggleBtn.addEventListener('click', openMobileMenu);

    // // Close mobile menu when close button is clicked
    // closeMobileMenuBtn.addEventListener('click', closeMobileMenu);

    // // Close menu when clicking outside of mobile menu
    // mobileMenu.addEventListener('click', (e) => {
    //     if (e.target === mobileMenu) {
    //         closeMobileMenu();
    //     }
    // });

    // // Prevent mobile menu from closing when clicking inside the menu content
    // mobileMenuContent.addEventListener('click', (e) => {
    //     e.stopPropagation();
    // });
</script>

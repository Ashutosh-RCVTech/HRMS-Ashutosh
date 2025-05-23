<!-- Mobile Menu Overlay -->
<div id="mobileMenu" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden">
    <div class="bg-white dark:bg-gray-800 w-64 h-full p-4 transform -translate-x-full transition-transform duration-200">
        <div class="flex justify-between items-center mb-6">
            <div class="font-bold text-xl text-primary-500">RCVJob</div>
            <button id="closeMobileMenu" class="text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="space-y-4">
            <a href="{{ route('landing') }}" target="_blank" class="block hover:text-primary-500 dark:text-white">About
                Us</a>
            <a href="{{ route('candidate.dashboard') }}" class="block hover:text-primary-500 dark:text-white">Find
                job</a>
            {{-- <a href="#" class="text-white hover:text-black">Messages</a> --}}
            <a href="{{ route('candidate.applications.index') }}"
                class="block hover:text-primary-500 dark:text-white">My
                Applications</a>

            <a href="{{ route('candidate.placement.index') }}"
                class="block hover:text-primary-500 dark:text-white">Placement
                Drives</a>

            {{-- <a href="/candidate/mcq/signin/{{ encrypt(12) }}" class="text-white hover:text-black">Take Test</a> --}}


            {{-- <a href="#" class="block hover:text-primary-500 dark:text-white">Hiring</a>
            <a href="#" class="block hover:text-primary-500 dark:text-white">Community</a> --}}
            <a href="{{ route('candidate.faq') }}" class="block hover:text-primary-500 dark:text-white">FAQ</a>
        </nav>
    </div>
</div>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    const mobileMenuContent = mobileMenu.querySelector('div');

    function toggleMobileMenu(show) {
        mobileMenu.classList.toggle('hidden', !show);
        if (show) {
            // Small delay to ensure the transition works
            setTimeout(() => {
                mobileMenuContent.classList.remove('-translate-x-full');
            }, 10);
        } else {
            mobileMenuContent.classList.add('-translate-x-full');
        }
    }

    mobileMenuBtn.addEventListener('click', () => toggleMobileMenu(true));
    closeMobileMenu.addEventListener('click', () => toggleMobileMenu(false));
    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu) toggleMobileMenu(false);
    });
    // });
</script>

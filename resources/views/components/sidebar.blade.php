<aside
    class="sidebar-wrapper fixed top-0 z-30 h-screen bg-white dark:bg-slate-900 transition-all duration-300 ease-in-out w-[308px] border-r border-gray-200 dark:border-gray-800">
    {{-- Full Sidebar Content --}}
    <div class="expanded-content h-full flex flex-col">
        <x-sidebar.body class="flex-1 overflow-y-auto" />
    </div>

    {{-- Collapsed Sidebar Content --}}
    <div class="collapsed-content hidden h-full flex flex-col">
        <x-sidebar.responsive-header />
        <x-sidebar.responsive-body class="flex-1 overflow-y-auto" />
    </div>

    {{-- Mobile Close Button --}}
    <button type="button" class="drawer-btn absolute right-0 top-auto md:hidden" title="Close Sidebar">
        <span>
            <svg width="16" height="40" viewBox="0 0 16 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z" fill="#bf125d" />
                <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </button>
</aside>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar-wrapper');
        const expandedContent = sidebar.querySelector('.expanded-content');
        const collapsedContent = sidebar.querySelector('.collapsed-content');
        const mobileCloseBtn = sidebar.querySelector('.drawer-btn');

        // Function to update sidebar content visibility
        function updateSidebarContent(isOpen) {
            if (isOpen) {
                expandedContent.classList.remove('hidden');
                collapsedContent.classList.add('hidden');
            } else {
                expandedContent.classList.add('hidden');
                collapsedContent.classList.remove('hidden');
            }
        }

        // Listen for sidebar state changes
        window.addEventListener('sidebarStateChanged', function(e) {
            updateSidebarContent(e.detail.isOpen);
        });

        // Initialize sidebar content based on saved state
        const isSidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
        updateSidebarContent(isSidebarOpen);

        // Add click event listener for mobile close button
        if (mobileCloseBtn) {
            mobileCloseBtn.addEventListener('click', function() {
                const isOpen = localStorage.getItem('sidebarOpen') !== 'false';
                updateSidebarContent(!isOpen);
                localStorage.setItem('sidebarOpen', !isOpen);
            });
        }
    });
</script> -->

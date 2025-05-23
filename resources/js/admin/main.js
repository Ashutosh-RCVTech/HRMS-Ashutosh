(function($) { 
    $(document).ready(function () {
        // Initialize sidebar state
        let sidebarCollapsed = false;
        let isMobileMenuHidden = window.innerWidth < 1024;
        
        function updateSidebarState() {
            const sidebar = document.querySelector('.sidebar-wrapper');
            const expandedContent = sidebar.querySelector('.expanded-content');
            const collapsedContent = sidebar.querySelector('.collapsed-content');
            const body = document.body;
            
            // Update sidebar width
            sidebar.style.width = sidebarCollapsed ? '96px' : '308px';
            
            // Toggle content visibility
            expandedContent.classList.toggle('hidden', sidebarCollapsed);
            collapsedContent.classList.toggle('hidden', !sidebarCollapsed);
            
            // Handle mobile view
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full', isMobileMenuHidden);
                body.style.paddingLeft = '0';
            } else {
                sidebar.classList.remove('-translate-x-full');
                body.style.paddingLeft = sidebarCollapsed ? '96px' : '308px';
            }
        }

        // Drawer toggle
        $(".drawer-btn").on("click", function () {
            if (window.innerWidth >= 1024) {
                sidebarCollapsed = !sidebarCollapsed;
            } else {
                isMobileMenuHidden = !isMobileMenuHidden;
            }
            
            updateSidebarState();
            
            // Update toggle button rotation
            $(this).find('span').css('transform', sidebarCollapsed ? 'rotate(180deg)' : 'rotate(0deg)');
        });

        // Handle window resize
        $(window).on('resize', function() {
            isMobileMenuHidden = window.innerWidth < 1024;
            updateSidebarState();
        });

        // Initial state setup
        updateSidebarState();

        // Drawer key access
        $(document).on("keydown", function (e) {
            if (e.key === "b" && e.ctrlKey) {
                e.preventDefault();
                e.stopPropagation();
                $(".drawer-btn").click();
            }
        });

        // Navigation Submenu
        $(".nav-wrapper .item > a").on("click", function (e) {
            e.preventDefault();
            const submenu = $(this).siblings(".sub-menu");
            submenu.toggleClass("active");
        });

        // Mode Setting
        $(".light-dark-mode").on("click", function () {
            const body = $("body");
            const mode = body.attr("data-mode") === "dark" ? "light" : "dark";
            body.attr("data-mode", mode);
            sessionStorage.setItem("data-layout-mode", mode);
        });

        const storedMode = sessionStorage.getItem("data-layout-mode");
        if (storedMode) {
            $("body").attr("data-mode", storedMode);
        }

        // // Theme Toggle
        // const theme = localStorage.getItem("theme");
        // if (theme === "dark" || window.matchMedia("(prefers-color-scheme: dark)").matches) {
        //     $("html").addClass("dark");
        // } else {
        //     $("html").removeClass("dark");
        // }

        // $("#theme-toggle").on("click", function () {
        //     const newTheme = localStorage.getItem("theme") === "dark" ? "light" : "dark";
        //     localStorage.setItem("theme", newTheme);
        //     $("html").toggleClass("dark", newTheme === "dark");
        // });
    });
})(jQuery);

function templateResult(data) {
    return data.name || data.text;
}

function templateSelection(data) {
    return data.name || data.text;
}

// Global functions
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar-wrapper');
    const expandedContent = sidebar.querySelector('.expanded-content');
    const collapsedContent = sidebar.querySelector('.collapsed-content');
    const body = document.body;
    
    // Toggle collapsed state
    const isCollapsed = sidebar.style.width === '96px';
    sidebar.style.width = isCollapsed ? '308px' : '96px';
    
    // Toggle content visibility
    expandedContent.classList.toggle('hidden', !isCollapsed);
    collapsedContent.classList.toggle('hidden', isCollapsed);
    
    // Update body padding on desktop
    if (window.innerWidth >= 1024) {
        body.style.paddingLeft = isCollapsed ? '308px' : '96px';
    }
    
    // Update toggle button rotation
    const toggleBtn = document.querySelector('.drawer-btn');
    if (toggleBtn) {
        const span = toggleBtn.querySelector('span');
        if (span) {
            span.style.transform = !isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }
}

function toggleProfileMenu() {
    const profileBox = document.querySelector('.profile-box');
    const profileOutside = document.querySelector('.profile-outside');
    
    if (profileBox && profileOutside) {
        profileBox.classList.toggle('hidden');
        profileOutside.classList.toggle('hidden');
    }
}

// Close profile menu when clicking outside
document.addEventListener('click', function(event) {
    const profileBox = document.querySelector('.profile-box');
    const profileOutside = document.querySelector('.profile-outside');
    const profileTrigger = document.querySelector('.profile-trigger');
    const profileMenuToggle = document.querySelector('.profile-menu-toggle');
    
    if (profileBox && profileOutside) {
        if (!profileTrigger?.contains(event.target) && !profileMenuToggle?.contains(event.target)) {
            profileBox.classList.add('hidden');
            profileOutside.classList.add('hidden');
        }
    }
});



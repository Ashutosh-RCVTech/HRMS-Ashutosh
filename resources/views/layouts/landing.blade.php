<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RCVJob Board - Find Your Dream Job | Job Search Platform')</title>
    <meta name="title" content="@yield('meta_title', 'RCVJob Board - Find Your Dream Job | Job Search Platform')">
    <meta name="description" content="@yield('meta_description', 'Discover thousands of job opportunities across various industries. Connect with top employers, get personalized job recommendations, and advance your career with RCVJob Board.')">
    <meta name="keywords" content="@yield('meta_keywords', 'job board, career opportunities, job search, employment, recruitment, hire talent, remote jobs, job listing, career development')">
    <meta name="rating" content="general">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('extra_head')
</head>

<body class="bg-gray-100 dark:bg-slate-900 transition-colors duration-200">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-900 shadow-lg fixed w-full z-50 dark:border-b-2">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-2xl font-bold text-primary-500">RCVJob Board</a>
                </div>
                <!-- Theme Toggle for Mobile -->
                <button id="mobile-theme-toggle"
                    class="md:hidden relative inline-flex h-9 w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition-colors duration-300 focus:outline-none">
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
                <!-- Mobile Toggle Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 dark:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Theme toggle (now only one theme toggle, visible on desktop) -->
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

                    <!-- Sign In Dropdown -->
                    <div class="relative">
                        <button id="signInMenuBtn"
                            class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transform hover:scale-105 transition-all duration-200">
                            <span class="mr-2">Get Started</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="signInDropdown"
                            class="hidden absolute right-0 mt-4 w-72 bg-white dark:bg-slate-800 shadow-xl rounded-lg py-4 z-50 transform transition-all duration-200 border border-gray-200 dark:border-gray-700">
                            <!-- Candidate Options -->
                            <div class="px-4 mb-4">
                                <h3
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Candidate
                                </h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('candidate.dashboard') }}"
                                        class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                        In</a>
                                    <a href="{{ route('candidate.register') }}"
                                        class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                        Up</a>
                                </div>
                            </div>

                            <!-- Organization Options -->
                            <div class="px-4 mb-4">
                                <h3
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Organization
                                </h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('organization') }}"
                                        class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                        In</a>
                                    <a href="{{ route('organization') }}"
                                        class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                        Up</a>
                                </div>
                            </div>

                            <!-- College Options -->
                            <div class="px-4">
                                <h3
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                    College
                                </h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('college.dashboard') }}"
                                        class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                        In</a>
                                    <a href="{{ route('college.register') }}"
                                        class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                        Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Accordion) -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-white dark:bg-slate-900 overflow-hidden transition-all duration-300 max-h-0">
            <div class="py-4 px-4 space-y-2">
                <button
                    class="w-full text-left text-gray-700 dark:text-white flex justify-between items-center py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors duration-200"
                    onclick="toggleAccordion('signIn')">
                    <span class="font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Get Started
                    </span>
                    <svg id="signInIcon" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="signIn"
                    class="hidden px-4 py-2 text-gray-600 dark:text-white overflow-hidden transition-all duration-300 max-h-0">
                    <!-- Candidate Options -->
                    <div class="mb-4 bg-gray-50 dark:bg-slate-800 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Candidate
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('candidate.dashboard') }}"
                                class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                In</a>
                            <a href="{{ route('candidate.register') }}"
                                class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                Up</a>
                        </div>
                    </div>

                    <!-- Organization Options -->
                    <div class="mb-4 bg-gray-50 dark:bg-slate-800 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Organization
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('organization') }}"
                                class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                In</a>
                            <a href="{{ route('organization') }}"
                                class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                Up</a>
                        </div>
                    </div>

                    <!-- College Options -->
                    <div class="bg-gray-50 dark:bg-slate-800 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            College
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('college.dashboard') }}"
                                class="flex-1 text-center py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium">Sign
                                In</a>
                            <a href="{{ route('college.register') }}"
                                class="flex-1 text-center py-2 bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200 text-sm font-medium">Sign
                                Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 dark:border-t-2">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">RCVJob Board</h3>
                    <p class="text-gray-400"><span class="font-bold ">RCVJob Board,</span> transforms the job search
                        landscape, making hiring and job hunting faster, simpler, and more efficient.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact Us</a>
                        </li>
                        <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white">Privacy
                                Policy</a>
                        </li>
                        <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-white">Terms of
                                Service</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">For Employers</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('organization') }}" class="text-gray-400 hover:text-white">Post a
                                Job</a>
                        </li>
                        <li><a href="{{ route('organization') }}" class="text-gray-400 hover:text-white">Browse
                                Candidates</a></li>
                        <li><a href="{{ route('organization') }}" class="text-gray-400 hover:text-white">Pricing
                                Plans</a></li>
                        <li><a href="{{ route('organization') }}" class="text-gray-400 hover:text-white">Employer
                                Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/rcvtechnologies" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                        <a href="https://x.com/rcvtechno" class="text-gray-400 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/company/rcvtechnologies"
                            class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z M2 9h4v12H2z M4 2a2 2 0 1 1-2 2 2 2 0 0 1 2-2z" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-4">
                        <h5 class="text-sm font-semibold mb-2">Subscribe to our newsletter</h5>
                        <form id="newsletter-form" class="flex">
                            <input type="email" id="newsletter-email" placeholder="Enter your email" required
                                class="w-full px-3 py-2 bg-gray-800 text-white rounded-l focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <button type="submit" id="newsletter-submit"
                                class="px-4 py-2 bg-primary-500 text-white rounded-r hover:bg-primary-600 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                                disabled>
                                Subscribe
                            </button>
                        </form>
                        <div id="newsletter-message" class="mt-2 text-sm"></div>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} RCVJob Board. All rights reserved.</p>
            </div>
        </div>

        {{-- @include('chatbot') --}}
    </footer>

    <script>
        // // Sign In Dropdown
        // document.addEventListener('DOMContentLoaded', function() {
        //     // Desktop dropdown functionality
        //     document
        //         .getElementById("signInMenuBtn")
        //         .addEventListener("click", function() {
        //             const dropdown = document.getElementById("signInDropdown");
        //             dropdown.classList.toggle("hidden");

        //             // Animation for showing dropdown
        //             if (!dropdown.classList.contains("hidden")) {
        //                 dropdown.classList.add("animate-fadeIn");
        //                 setTimeout(() => {
        //                     dropdown.classList.remove("animate-fadeIn");
        //                 }, 300);
        //             }
        //         });

        //     document.addEventListener("click", function(event) {
        //         const signInDropdown = document.getElementById("signInDropdown");
        //         const signInMenuBtn = document.getElementById("signInMenuBtn");

        //         if (
        //             !signInMenuBtn.contains(event.target) &&
        //             !signInDropdown.contains(event.target)
        //         ) {
        //             signInDropdown.classList.add("hidden");
        //         }
        //     });

        //     // Mobile menu toggle
        //     const mobileMenuButton = document.getElementById("mobile-menu-button");
        //     const mobileMenu = document.getElementById("mobile-menu");

        //     mobileMenuButton.addEventListener("click", function() {
        //         const isOpen = !mobileMenu.classList.contains("hidden");

        //         if (isOpen) {
        //             // Close the menu with animation
        //             mobileMenu.style.maxHeight = "0";
        //             setTimeout(() => {
        //                 mobileMenu.classList.add("hidden");
        //             }, 300);
        //         } else {
        //             // Open the menu with animation
        //             mobileMenu.classList.remove("hidden");
        //             setTimeout(() => {
        //                 mobileMenu.style.maxHeight = "500px"; // Adjust as needed
        //             }, 10);
        //         }
        //     });

        //     // Toggle accordion functionality for mobile menu
        //     window.toggleAccordion = function(id) {
        //         const accordion = document.getElementById(id);
        //         const icon = document.getElementById(id + "Icon");

        //         if (accordion.classList.contains("hidden")) {
        //             // Open accordion
        //             accordion.classList.remove("hidden");
        //             accordion.style.maxHeight = "0";

        //             setTimeout(() => {
        //                 accordion.style.maxHeight = accordion.scrollHeight + "px";
        //                 if (icon) icon.classList.add("rotate-180");
        //             }, 10);
        //         } else {
        //             // Close accordion
        //             accordion.style.maxHeight = "0";
        //             if (icon) icon.classList.remove("rotate-180");

        //             setTimeout(() => {
        //                 accordion.classList.add("hidden");
        //             }, 300);
        //         }
        //     };

        //     // Theme toggle functionality
        //     const themeToggle = document.getElementById("theme-toggle");
        //     const mobileThemeToggle = document.getElementById("mobile-theme-toggle");

        //     // Function to toggle theme
        //     function toggleTheme() {
        //         document.documentElement.classList.toggle("dark");

        //         // Save theme preference to localStorage
        //         if (document.documentElement.classList.contains("dark")) {
        //             localStorage.theme = "dark";
        //         } else {
        //             localStorage.theme = "light";
        //         }
        //     }

        //     themeToggle.addEventListener("click", toggleTheme);
        //     mobileThemeToggle.addEventListener("click", toggleTheme);

        //     // Apply saved theme on page load
        //     if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
        //             '(prefers-color-scheme: dark)').matches)) {
        //         document.documentElement.classList.add('dark');
        //     } else {
        //         document.documentElement.classList.remove('dark');
        //     }

        //     // Newsletter form validation
        //     const newsletterForm = document.getElementById("newsletter-form");
        //     const newsletterEmail = document.getElementById("newsletter-email");
        //     const newsletterSubmit = document.getElementById("newsletter-submit");
        //     const newsletterMessage = document.getElementById("newsletter-message");

        //     newsletterEmail.addEventListener("input", function() {
        //         const isValid = newsletterEmail.checkValidity();
        //         newsletterSubmit.disabled = !isValid;
        //     });

        //     newsletterForm.addEventListener("submit", function(e) {
        //         e.preventDefault();
        //         newsletterSubmit.disabled = true;
        //         newsletterMessage.textContent = "Processing...";

        //         // Simulate API call
        //         setTimeout(() => {
        //             newsletterMessage.textContent = "Thank you for subscribing!";
        //             newsletterMessage.classList.add("text-green-400");
        //             newsletterEmail.value = "";
        //         }, 1000);
        //     });
        // });
    </script>

    <style>
        /* Animation for navbar elements */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Smooth transitions for accordions */
        #mobile-menu {
            transition: max-height 0.3s ease-in-out;
        }

        #signIn {
            transition: max-height 0.3s ease-in-out;
        }

        /* Rotate animation for accordion icons */
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    @if (Session::has('message'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif

    <!-- Page Scripts -->
    @yield('scripts')

</body>

</html>

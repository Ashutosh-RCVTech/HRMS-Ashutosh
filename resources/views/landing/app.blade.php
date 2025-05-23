@extends('layouts.landing')
@section('content')
    <!-- Global Search Section -->
    <section class="relative bg-gradient-to-r from-pink-500 to-pink-200 py-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('images/background.jpg') }}" class="h-full w-full object-cover" alt="background" />
        </div>

        <!-- Semi-transparent overlay to improve text readability -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <div class="container mx-auto px-4 relative">
            {{-- <!-- Main Content -->
            <div class="text-center mb-12">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-4">
                    The Right People. The Right Jobs. The Right Roles
                </h1>
                <div class="text-xl text-white/90 h-8 mb-8">
                    <span class="text-bold">Success Begins with the Perfect Fit</span>
                </div>
                <p class=" ml-12 text-white/80 text-lg mb-2">
                    <span class="font-bold text-white">Why struggle with hiring or job searching when RCV makes it
                        easy?</span>
                    We connect top talent with leading employers, ensuring a smooth and efficient.<br>
                    <span class="font-bold">process.</span>
                </p>

            </div> --}}

            <div class="text-center mb-12">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 drop-shadow-md">
                    Connecting Exceptional Talent with Transformative Opportunities
                </h1>
                <div class="text-xl text-white h-8 mb-8 drop-shadow-md">
                    <span class="font-bold">Where Careers Flourish and Companies Thrive</span>
                </div>
                <p class="ml-12 text-white text-lg mb-2 drop-shadow-md">
                    <span class="font-bold">Why navigate the complexities of talent acquisition alone when RCV
                        elevates the entire experience?</span>
                    We leverage cutting-edge technology to match visionary professionals with forward-thinking
                    organizations, creating meaningful connections that drive innovation and growth.<br>
                    <span class="font-bold">Your success is our mission.</span>
                </p>
                <div id="animated-text" class="text-2xl font-bold text-white mb-4 drop-shadow-md"></div>
            </div>


            <!-- Search Form -->
            <div class="max-w-4xl mx-auto">
                <form id="search-form" action="{{ route('candidate.jobs.index') }}" method="GET" class="relative ">
                    <div class="flex flex-col md:flex-row gap-4 bg-white p-2 rounded-xl shadow-2xl dark:bg-slate-900">
                        <!-- Skills/Job Input -->
                        <div class="flex-1 relative group">
                            <div class="absolute inset-y-0 left-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search-input"
                                class="w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white"
                                placeholder="Skills, Companies or Job Titles">

                            {{-- Suggestions container --}}
                            <div class="relative">
                                <div id="suggestions-container"
                                    class="absolute top-full left-0 right-0 mt-2 hidden max-h-60 overflow-y-auto bg-white dark:bg-slate-900 rounded-lg shadow-xl z-50">
                                </div>
                            </div>
                        </div>

                        <!-- Location Input -->
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <select name="location"
                                class="w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white">
                                <option value="">All Locations</option>
                                @foreach ($locations ?? [] as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Experience Dropdown -->
                        <div class="flex-1 relative">
                            <select name="experience_required"
                                class="w-full py-3 px-4 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white">
                                <option value="">Experience Level</option>
                                <option value="0-2">0-2 years</option>
                                <option value="2-5">2-5 years</option>
                                <option value="5-8">5-8 years</option>
                                <option value="8+">8+ years</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" id="submit-button"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                            disabled>
                            <span>Search</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-20 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-500 mb-2">15K+</div>
                    <div class="text-gray-600 dark:text-white">Active Job Listings</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-500 mb-2">10K+</div>
                    <div class="text-gray-600 dark:text-white">Successful Placements</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-500 mb-2">5K+</div>
                    <div class="text-gray-600 dark:text-white">Partner Companies</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="container mx-auto mb-12 mt-2 dark:border-t-2">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 mt-1 text-center dark:text-white ">Popular Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">🏦</span>
                <p class="text-gray-700 dark:text-white">Banking</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">🏠</span>
                <p class="text-gray-700 dark:text-white">Work From Home</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">🧑‍💼</span>
                <p class="text-gray-700 dark:text-white">HR</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">🛍️</span>
                <p class="text-gray-700 dark:text-white">Sales</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">📊</span>
                <p class="text-gray-700 dark:text-white">Accounting</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">🎨</span>
                <p class="text-gray-700 dark:text-white">Graphic Design</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">💻</span>
                <p class="text-gray-700 dark:text-white">IT</p>
            </div>
            <div
                class="flex items-center space-x-3 bg-white p-6 shadow rounded-lg hover:shadow-lg transition dark:bg-pink-600">
                <span class="text-orange-500 text-2xl">📈</span>
                <p class="text-gray-700 dark:text-white">Digital Marketing</p>
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-slate-900 dark:border-t-2">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Why Choose RCVJob Board</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature cards -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Smart Job Matches</h3>
                    <p class="text-gray-600 dark:text-white">Advanced AI-powered matching algorithms that connect you with
                        highly relevant opportunities tailored to your skills and preferences.</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Real-Time Updates</h3>
                    <p class="text-gray-600 dark:text-white">Comprehensive application tracking with instant notifications
                        and feedback, helping you stay ahead in your job search journey.</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Direct Recruiter Access</h3>
                    <p class="text-gray-600 dark:text-white">Seamless communication channels with hiring managers and
                        recruiters, giving you a competitive edge in the selection process.
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Ironclad Security</h3>
                    <p class="text-gray-600 dark:text-white">Enterprise-grade protection for your personal data with
                        end-to-end encryption and strict privacy controls to eliminate security concerns.
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Full Support System</h3>
                    <p class="text-gray-600 dark:text-white">Comprehensive job alerting system with AI-driven career tips
                        and personalized hiring assistance to optimize your productivity and time management.
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                    <div
                        class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Career Insights Dashboard</h3>
                    <p class="text-gray-600 dark:text-white">Interactive analytics platform showcasing industry trends,
                        salary benchmarks, and personalized career growth opportunities to make informed decisions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Options Section -->
    <section id="login-options" class="py-20 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Choose Your Path</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Organization Card -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 hover:shadow-slate-400">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">For Organizations
                        </h3>
                        <ul class="space-y-3 mb-8 text-gray-600 dark:text-white">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                AI-Powered Talent Matching
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Advanced candidate filtering
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Analytics dashboard
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Smart Candidate Management
                            </li>
                        </ul>
                        <div class="flex space-x-2">
                            <a href="{{ route('organization') }}"
                                class="flex-1 py-3 px-4 text-center bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                                Sign In
                            </a>
                            {{-- <a href="{{ route('organization.register') }}" --}}
                            <a href="{{ route('organization') }}"
                                class="flex-1 py-3 px-4 text-center bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>

                <!-- College Card -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 hover:shadow-slate-400">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">For Colleges</h3>
                        <ul class="space-y-3 mb-8 text-gray-600 dark:text-white">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Campus Drive Management
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Student Placement Tracking
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Direct Employer Connections
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Comprehensive Reports
                            </li>
                        </ul>
                        <div class="flex space-x-2">
                            <a href="{{ route('college.login') }}"
                                class="flex-1 py-3 px-4 text-center bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                                Sign In
                            </a>
                            <a href="{{ route('college.register') }}"
                                class="flex-1 py-3 px-4 text-center bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Candidate Card -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 hover:shadow-slate-400">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">For Job Seekers</h3>
                        <ul class="space-y-3 mb-8 text-gray-600 dark:text-white">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Personalized recommendations
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Real-Time Application Tracking
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Exclusive Industry Openings
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                24/7 Job Alerts
                            </li>
                        </ul>
                        <div class="flex space-x-2">
                            <a href="{{ route('candidate.login') }}"
                                class="flex-1 py-3 px-4 text-center bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                                Sign In
                            </a>
                            <a href="{{ route('candidate.register') }}"
                                class="flex-1 py-3 px-4 text-center bg-white text-primary-500 border border-primary-500 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Form Modal -->
    <div id="contact-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-primary-500 text-white px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold">Contact Us</h3>
                <button id="close-contact-modal" class="text-white hover:text-gray-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 dark:text-white mb-4">Have questions or need assistance? Let us know how we can
                    help you.</p>

                <form id="contact-form" action="{{ route('contact.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-white mb-2">Name</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-white mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 dark:text-white mb-2">Subject</label>
                        <select id="subject" name="subject" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white">
                            <option value="">Select a subject</option>
                            <option value="General Enquiry">General Enquiry</option>
                            {{-- <option value="Technical Support">Technical Support</option> --}}
                            <option value="Feedback">Feedback</option>
                            <option value="Partnership Opportunities">Partnership Opportunities</option>
                        </select>
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 dark:text-white mb-2">Message</label>
                        <textarea id="message" name="message" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white"></textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="attachments" class="block text-gray-700 dark:text-white mb-2">Attachments
                            (Optional)</label>
                        <input type="file" id="attachments" name="attachments[]" multiple
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 5 files. Supported formats: PDF, DOC,
                            DOCX, JPG, JPEG, PNG, ZIP (Max 5MB each)</p>
                        @error('attachments.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" id="contact-submit"
                            class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            Send Message
                        </button>
                        <div id="contact-message-status" class="text-sm"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        // Contact Form Modal
        document.addEventListener("DOMContentLoaded", function() {
            const contactModal = document.getElementById("contact-modal");
            const closeModalBtn = document.getElementById("close-contact-modal");
            const contactForm = document.getElementById("contact-form");
            const contactMessageStatus = document.getElementById(
                "contact-message-status"
            );

            // Show modal after 1 seconds (or immediately if ?contact=true in URL)
            const urlParams = new URLSearchParams(window.location.search);
            const showContactParam = urlParams.get("contact");

            if (showContactParam === "true") {
                showContactModal();
            } else {
                // Check if the user has dismissed the modal before
                const contactModalDismissed = localStorage.getItem(
                    "contact-modal-dismissed"
                );

                setTimeout(showContactModal, 1000);
            }

            function showContactModal() {
                contactModal.classList.remove("hidden");
                // Add a class for fade-in animation if desired
                contactModal.classList.add("animate-fade-in");
            }

            // Close modal when clicking the close button
            closeModalBtn.addEventListener("click", function() {
                contactModal.classList.add("hidden");
                localStorage.setItem("contact-modal-dismissed", "true");
            });

            // Close modal when clicking outside the modal content
            contactModal.addEventListener("click", function(e) {
                if (e.target === contactModal) {
                    contactModal.classList.add("hidden");
                    localStorage.setItem("contact-modal-dismissed", "true");
                }
            });

            // Handle contact form submission
            contactForm.addEventListener("submit", async function(e) {
                e.preventDefault();

                const name = document.getElementById("name").value.trim();
                const email = document.getElementById("email").value.trim();
                const subject = document.getElementById("subject").value;
                const message = document.getElementById("message").value.trim();

                // if (!name || !email || !subject || !message) {
                //     contactMessageStatus.textContent = "Please fill out all fields";
                //     contactMessageStatus.className = "text-sm text-red-500";
                //     return;
                // }

                const emailRegex = /^[a-zA-Z0-9._%+-]+@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;

                if (!name || !email || !subject || !message) {
                    contactMessageStatus.textContent = "Please fill out all fields";
                    contactMessageStatus.className = "text-sm text-red-500";
                    return;
                }

                if (!emailRegex.test(email)) {
                    contactMessageStatus.textContent = "Please enter a valid email address";
                    contactMessageStatus.className = "text-sm text-red-500";
                    return;
                }


                // Show loading state
                const submitBtn = document.getElementById("contact-submit");
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML =
                    '<div class="flex items-center"><div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>Sending...</div>';
                submitBtn.disabled = true;

                try {
                    // API endpoint
                    const response = await fetch("{{ route('contact.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .content,
                        },
                        body: JSON.stringify({
                            name,
                            email,
                            subject,
                            message
                        }),
                    });

                    if (response.ok) {
                        contactMessageStatus.textContent =
                            "Thank you! Your message has been sent.";
                        contactMessageStatus.className = "text-sm text-green-500";
                        contactForm.reset();

                        // Close modal after 3 seconds
                        // setTimeout(() => {
                        //     contactModal.classList.add("hidden");
                        //     localStorage.setItem("contact-modal-submitted", "true");
                        // }, 1000);

                        // Refresh page after short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);

                    } else {
                        const data = await response.json();
                        contactMessageStatus.textContent =
                            data.message || "Failed to send message. Please try again.";
                        contactMessageStatus.className = "text-sm text-red-500";
                    }
                } catch (error) {
                    contactMessageStatus.textContent =
                        "An error occurred. Please try again later.";
                    contactMessageStatus.className = "text-sm text-red-500";
                } finally {
                    // Reset button state
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contact-form');
            const statusDiv = document.getElementById('contact-message-status');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const submitButton = document.querySelector('#contact-form button[type="submit"]');

                    // Disable the submit button and show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Sending...';
                    statusDiv.textContent = '';

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Success message
                                statusDiv.textContent = data.message;
                                statusDiv.className = 'text-sm text-green-500';
                                form.reset();
                            } else {
                                // Error message
                                statusDiv.textContent = data.message ||
                                    'An error occurred. Please try again.';
                                statusDiv.className = 'text-sm text-red-500';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            statusDiv.textContent = 'An error occurred. Please try again.';
                            statusDiv.className = 'text-sm text-red-500';
                        })
                        .finally(() => {
                            // Re-enable the submit button
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Send Message';
                        });
                });
            }
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const contactModal = document.getElementById("contact-modal");
            const closeModalBtn = document.getElementById("close-contact-modal");
            const contactForm = document.getElementById("contact-form");
            const contactMessageStatus = document.getElementById("contact-message-status");
            const fileInput = document.getElementById("attachment"); // Assuming you have a file input
            const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB in bytes

            // Show modal logic
            const urlParams = new URLSearchParams(window.location.search);
            const showContactParam = urlParams.get("contact");

            if (showContactParam === "true") {
                showContactModal();
            } else {
                const contactModalDismissed = localStorage.getItem("contact-modal-dismissed");
                setTimeout(showContactModal, 1000);
            }

            function showContactModal() {
                contactModal.classList.remove("hidden");
                contactModal.classList.add("animate-fade-in");
            }

            // Close modal logic
            closeModalBtn.addEventListener("click", function() {
                contactModal.classList.add("hidden");
                localStorage.setItem("contact-modal-dismissed", "true");
            });

            contactModal.addEventListener("click", function(e) {
                if (e.target === contactModal) {
                    contactModal.classList.add("hidden");
                    localStorage.setItem("contact-modal-dismissed", "true");
                }
            });

            // Improved form submission handler
            contactForm.addEventListener("submit", async function(e) {
                e.preventDefault();
                
                // Reset status message
                contactMessageStatus.textContent = "";
                contactMessageStatus.className = "text-sm";

                // Get form values
                const name = document.getElementById("name").value.trim();
                const email = document.getElementById("email").value.trim();
                const subject = document.getElementById("subject").value;
                const message = document.getElementById("message").value.trim();
                const file = fileInput?.files[0];

                // Client-side validation
                if (!name || !email || !subject || !message) {
                    showError("Please fill out all required fields");
                    return false;
                }

                const emailRegex = /^[a-zA-Z0-9._%+-]+@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
                if (!emailRegex.test(email)) {
                    showError("Please enter a valid email address");
                    return false;
                }

                // File size validation
                if (fileInput && file) {
                    if (file.size > MAX_FILE_SIZE) {
                        showError("File size exceeds the 5MB limit");
                        fileInput.value = ""; // Clear the invalid file
                        return false;
                    }
                }

                // Prepare for submission
                const submitBtn = document.getElementById("contact-submit");
                const originalBtnText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.innerHTML = '<div class="flex items-center"><div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>Sending...</div>';
                submitBtn.disabled = true;

                try {
                    const formData = new FormData(contactForm);
                    
                    const response = await fetch("{{ route('contact.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json",
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (response.ok) {
                        showSuccess(data.message || "Thank you! Your message has been sent.");
                        contactForm.reset();
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showError("Failed to send message. Please try again.");
                        // Improved error message handling
                        // if (data.errors) {
                        //     if (data.errors.attachment) {
                        //         showError("File size exceeds the 5MB limit");
                        //     } else {
                        //         const firstError = Object.values(data.errors)[0][0];
                        //         showError(firstError);
                        //     }
                        // } else {
                        //     showError(data.message || "Failed to send message. Please try again.");
                        // }
                    }
                } catch (error) {
                    console.error("Error:", error);
                    showError("An error occurred. Please try again later.");
                } finally {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            });

            // Helper functions
            function showError(message) {
                contactMessageStatus.textContent = message;
                contactMessageStatus.className = "text-sm text-red-500";
                contactMessageStatus.style.display = "block";
            }

            function showSuccess(message) {
                contactMessageStatus.textContent = message;
                contactMessageStatus.className = "text-sm text-green-500";
                contactMessageStatus.style.display = "block";
            }

            // File size validation on file selection
            if (fileInput) {
                fileInput.addEventListener("change", function() {
                    const file = this.files[0];
                    if (file && file.size > MAX_FILE_SIZE) {
                        showError("File size exceeds the 5MB limit");
                        this.value = ""; // Clear the file input
                    } else {
                        contactMessageStatus.style.display = "none";
                    }
                });
            }
        });
    </script>
    </script>
    <script>
        // Search Input Handling
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const submitButton = document.getElementById('submit-button');
            const suggestionsContainer = document.getElementById('suggestions-container');
            let debounceTimer;

            // Update button state and handle suggestions
            function updateButtonState() {
                submitButton.disabled = !searchInput.value.trim();
            }

            // Clear suggestions
            function clearSuggestions() {
                suggestionsContainer.innerHTML = '';
                suggestionsContainer.classList.add('hidden');
            }

            // Show loading state
            function showLoading() {
                suggestionsContainer.innerHTML = `
            <div class="p-3 text-gray-500 dark:text-gray-300">
                <div class="flex items-center justify-center space-x-2">
                    <div class="w-5 h-5 border-2 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
                    <span>Searching...</span>
                </div>
            </div>
        `;
                suggestionsContainer.classList.remove('hidden');
            }

            // Fetch suggestions
            async function fetchSuggestions(query) {
                try {
                    const response = await fetch(`/api/jobs/suggestions?query=${encodeURIComponent(query)}`);
                    if (!response.ok) throw new Error('Failed to fetch');
                    const data = await response.json();
                    return data.results; // Access the results array from the response
                } catch (error) {
                    console.error('Suggestions error:', error);
                    return [];
                }
            }

            // Display suggestions
            function displaySuggestions(suggestions) {
                if (suggestions.length === 0) {
                    suggestionsContainer.innerHTML = `
                <div class="p-3 text-gray-500 dark:text-gray-300">
                    No matching jobs found
                </div>
            `;
                    return;
                }

                suggestionsContainer.innerHTML = suggestions
                    .map(suggestion => `
                <div class="p-3 hover:bg-gray-100 dark:hover:bg-slate-600 cursor-pointer transition-colors suggestion-item" 
                     data-suggestion="${suggestion.replace(/"/g, '&quot;')}">
                    <div class="font-medium dark:text-white">${suggestion}</div>
                </div>
            `).join('');

                suggestionsContainer.classList.remove('hidden');
            }

            // Event delegation for suggestion clicks
            suggestionsContainer.addEventListener('click', function(e) {
                const suggestionItem = e.target.closest('.suggestion-item');
                if (suggestionItem) {
                    const suggestion = suggestionItem.getAttribute('data-suggestion');
                    searchInput.value = suggestion;
                    clearSuggestions();
                    submitButton.disabled = false;
                    searchInput.focus();
                }
            });

            // Input event handler
            searchInput.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                updateButtonState();

                const query = this.value.trim();
                if (!query) {
                    clearSuggestions();
                    return;
                }

                if (query.length < 2) {
                    clearSuggestions();
                    return;
                }

                showLoading();
                debounceTimer = setTimeout(async () => {
                    try {
                        const suggestions = await fetchSuggestions(query);
                        displaySuggestions(suggestions);
                    } catch (error) {
                        suggestionsContainer.innerHTML = `
                    <div class="p-3 text-red-500">
                        Failed to load suggestions
                    </div>
                `;
                    }
                }, 300);
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                    clearSuggestions();
                }
            });

            // Handle form submission
            document.getElementById('search-form').addEventListener('submit', (e) => {
                clearSuggestions();
            });

            // Text Animation
            (function() {
                const phrases = [
                    'Find the perfect role for you',
                    'Discover opportunities worldwide',
                    'Start your career journey today'
                ];
                const animatedText = document.getElementById('animated-text');
                if (!animatedText) return; // Exit if the element is not found

                let currentPhraseIndex = 0;
                let currentCharIndex = 0;
                let isDeleting = false;
                let typingSpeed = 100;

                function typeText() {
                    const currentPhrase = phrases[currentPhraseIndex];
                    const displayText = currentPhrase.substring(0, currentCharIndex);

                    animatedText.textContent = displayText; // Set text content

                    if (!isDeleting && displayText === currentPhrase) {
                        typingSpeed = 2000;
                        isDeleting = true;
                    } else if (isDeleting && displayText === '') {
                        isDeleting = false;
                        currentPhraseIndex = (currentPhraseIndex + 1) % phrases.length;
                        typingSpeed = 100;
                    }

                    currentCharIndex = isDeleting ? currentCharIndex - 1 : currentCharIndex + 1;
                    setTimeout(typeText, typingSpeed);
                }

                typeText();
            })();
        });
    </script>
@endsection

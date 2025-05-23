@extends('layouts.landing')
@section('title', 'RCVJob Board Organization Portal - Coming Soon')
@section('meta_description',
    'Our upcoming Organization Portal will transform how you manage job postings, candidate
    pipelines, and company profiles. Be among the first to experience next-gen recruitment management.')

@section('content')
    <div class="container mx-auto px-4 pt-24 pb-12">
        <div
            class="glass-card rounded-2xl p-8 md:p-12 max-w-5xl mx-auto w-full space-y-8 transform transition-all duration-500 hover:scale-[1.005] bg-white/5 border border-white/10 dark:bg-slate-800/30">
            <!-- Header Section -->
            <div class="text-center space-y-6">
                <div class="floating inline-block">
                    <div class="p-4 bg-white/5 rounded-2xl border border-black/10">
                        <span
                            class="text-4xl font-bold bg-gradient-to-r from-primary-500 to-primary-900 bg-clip-text text-transparent">
                            RCVJob Board
                        </span>
                    </div>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                    Empowering Organizations in
                    <span class="bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text text-transparent">Talent
                        Management</span>
                </h1>

                <p class="text-gray-700 dark:text-gray-300 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                    Our upcoming Organization Portal will transform how you manage job postings, candidate pipelines,
                    and company profiles. Be among the first to experience next-gen recruitment management.
                </p>
            </div>

            <!-- Coming Soon Section -->
            <div class="text-3xl font-mono font-bold text-primary-500 text-center">Coming Soon</div>

            <!-- Early Access Form -->
            <div class="space-y-6">
                <div class="relative group">
                    <input type="email" id="corporate-email"
                        class="w-full px-6 py-4 bg-white/5 border border-black/10 rounded-2xl outline-none focus:border-primary-400/50 focus:ring-2 focus:ring-primary-400/20 transition-all placeholder-gray-500 dark:placeholder-gray-400 text-gray-700 dark:text-white"
                        placeholder="Enter your email for priority access">
                    <button id="request-demo-btn"
                        class="absolute right-2 top-2 bottom-2 md:px-6 px-3 bg-primary-500 rounded-xl font-medium hover:opacity-90 transition-opacity text-white text-sm md:text-base">
                        <span class="hidden md:inline">Request Demo</span>
                        <span class="md:hidden">Demo</span>
                    </button>
                </div>
                <p class="text-center text-gray-600 dark:text-gray-400 text-sm">
                    Trusted by 850+ HR teams worldwide
                </p>
            </div>

            <!-- Key Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
                <div
                    class="glass-card p-6 rounded-xl bg-white/5 border border-white/10 dark:bg-slate-800/50 hover:bg-white/10 dark:hover:bg-slate-700/50 transition-all">
                    <svg class="w-12 h-12 mx-auto text-primary-500 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0  014 0z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Candidate Management</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Advanced applicant tracking system</p>
                </div>
                <div
                    class="glass-card p-6 rounded-xl bg-white/5 border border-white/10 dark:bg-slate-800/50 hover:bg-white/10 dark:hover:bg-slate-700/50 transition-all">
                    <svg class="w-12 h-12 mx-auto text-primary-500 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Job Posting Suite</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Multi-platform job distribution</p>
                </div>
            </div>

            <!-- Additional Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div
                    class="glass-card p-5 rounded-xl bg-white/5 border border-white/10 dark:bg-slate-800/50 hover:bg-white/10 dark:hover:bg-slate-700/50 transition-all">
                    <svg class="w-10 h-10 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Analytics Dashboard</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Comprehensive recruitment metrics</p>
                </div>
                <div
                    class="glass-card p-5 rounded-xl bg-white/5 border border-white/10 dark:bg-slate-800/50 hover:bg-white/10 dark:hover:bg-slate-700/50 transition-all">
                    <svg class="w-10 h-10 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Interview Scheduler</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Automated calendar integration</p>
                </div>
                <div
                    class="glass-card p-5 rounded-xl bg-white/5 border border-white/10 dark:bg-slate-800/50 hover:bg-white/10 dark:hover:bg-slate-700/50 transition-all">
                    <svg class="w-10 h-10 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Team Collaboration</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Streamlined hiring workflow</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Form Submission
        document.getElementById('request-demo-btn').addEventListener('click', (e) => {
            e.preventDefault();
            const email = document.getElementById('corporate-email').value;
            if (validateEmail(email)) {
                // Add your submission logic here
                alert('Thank you for your interest in RCVJob Board! We\'ll contact you soon.');
                document.getElementById('corporate-email').value = '';
            } else {
                alert('Please enter a valid corporate email address');
            }
        });

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    </script>
@endsection

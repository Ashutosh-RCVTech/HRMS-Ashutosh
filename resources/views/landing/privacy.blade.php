@extends('layouts.landing')

@section('content')
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-8 dark:text-white">Privacy Policy</h1>

            <div class="prose dark:prose-invert">
                <p class="text-lg dark:text-white">Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.</p>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">1. Information Collection</h2>
                <p class=" dark:text-white">We collect information when you register, apply for jobs, or interact with our services...</p>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">2. Data Usage</h2>
                <p class=" dark:text-white">We use your information to:</p>
                <ul class="list-disc pl-6">
                    <li class=" dark:text-white">Provide personalized job matches</li>
                    <li class=" dark:text-white">Improve our services</li>
                    <li class=" dark:text-white">Communicate important updates</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">3. Data Protection</h2>
                <p class=" dark:text-white">We implement industry-standard security measures including encryption and regular audits...</p>

                <div class="mt-8 bg-primary-50 dark:bg-slate-800 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold dark:text-white">Policy Updates</h3>
                    <p class="mt-2 dark:text-white">Last updated: [Mar 06, 2025]</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

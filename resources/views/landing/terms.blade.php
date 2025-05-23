@extends('layouts.landing')

@section('content')
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-8">Terms of Service</h1>

            <div class="prose dark:prose-invert">
                <p class="text-lg dark:text-white">By using RCVJob Board, you agree to these terms and conditions.</p>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">1. Account Responsibilities</h2>
                <p class=" dark:text-white">Users must provide accurate information and maintain account security...</p>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">2. Content Guidelines</h2>
                <p class=" dark:text-white">Prohibited content includes:</p>
                <ul class="list-disc pl-6">
                    <li class=" dark:text-white">False information</li>
                    <li class=" dark:text-white">Discriminatory job postings</li>
                    <li class=" dark:text-white">Spam or irrelevant content</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 dark:text-white">3. Service Modifications</h2>
                <p class=" dark:text-white">We reserve the right to modify or discontinue services at any time...</p>

                <div class="mt-8 bg-primary-50 dark:bg-slate-800 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold dark:text-white">Contact for Questions</h3>
                    <p class="mt-2 dark:text-white">Email legal@rcvjobboard.com for any terms-related inquiries</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

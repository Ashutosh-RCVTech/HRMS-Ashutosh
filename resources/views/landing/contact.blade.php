@extends('layouts.landing')

@section('content')
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-8">Contact Us</h1>

            <div class="bg-white dark:bg-slate-800 p-8 rounded-lg shadow-lg">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 dark:text-white">Get in Touch</h2>
                    <p class="text-gray-600 dark:text-gray-300">Have questions or need support? Our team is ready to help!</p>
                </div>

                <!-- Your existing modal form -->
                <form id="contact-form">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-white mb-2">Full Name</label>
                        <input type="text" required class="w-full px-4 py-3 border rounded-lg dark:bg-slate-700">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-white mb-2">Email Address</label>
                        <input type="email" required class="w-full px-4 py-3 border rounded-lg dark:bg-slate-700">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-white mb-2">Message</label>
                        <textarea rows="5" required class="w-full px-4 py-3 border rounded-lg dark:bg-slate-700"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg hover:bg-primary-600 transition">
                        Send Message
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold mb-4 dark:text-white">Other Ways to Reach Us</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-500">...</svg>
                            <span class="dark:text-white">support@rcvjobboard.com</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-500">...</svg>
                            <span class="dark:text-white">+1 (555) 123-4567</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

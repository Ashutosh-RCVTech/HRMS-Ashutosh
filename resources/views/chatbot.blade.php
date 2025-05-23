<!-- Recruitment Chatbot Container -->
<div class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button id="chatButton" class="bg-primary-600 hover:bg-primary-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="chatWindow" class="fixed bottom-20 right-4 w-96 bg-white dark:bg-slate-800 rounded-lg shadow-xl transition-all duration-300 transform hidden">
        <!-- Chat Header -->
        <div class="bg-primary-600 text-white p-4 rounded-t-lg flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">RCV Recruitment Assistant</h3>
                    <p class="text-sm opacity-75">Connecting Talent with Opportunities</p>
                </div>
            </div>
            <button id="closeChat" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Quick Action Buttons -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-2 gap-2">
                <button id="btn-candidate" class="quick-action-btn bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>For Candidates</span>
                </button>
                <button id="btn-college" class="quick-action-btn bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span>For Colleges</span>
                </button>
                <button id="btn-organization" class="quick-action-btn bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>For Organizations</span>
                </button>
                <button id="btn-help" class="quick-action-btn bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 4-5 3-5 9m0-12h.01" />
                    </svg>
                    <span>Need Help?</span>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chatMessages" class="h-96 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-slate-800"></div>

        <!-- Chat Input -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <form id="chatForm" class="flex space-x-2">
                <input
                    id="messageInput"
                    type="text"
                    placeholder="Type your message..."
                    class="flex-1 text-black border border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                />
                <button
                    type="submit"
                    class="bg-primary-600 text-white rounded-lg px-4 py-2 hover:bg-primary-700 transition-colors"
                >
                    Send
                </button>
            </form>
        </div>
    </div>
</div>
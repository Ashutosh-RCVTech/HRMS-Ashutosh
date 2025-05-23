@extends('layouts.admin')

@section('title', 'View Contact Message - Admin Dashboard')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Contact Message</h1>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.contacts.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to List
                        </a>
                        <button id="delete-btn"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                            Delete Message
                        </button>
                    </div>
                </div>

                <!-- Message Details -->
                <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg overflow-hidden">
                    <!-- Message Header -->
                    <div class="border-b dark:border-gray-700 p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $contact->is_read
                                    ? 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200'
                                    : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                    {{ $contact->is_read ? 'Read' : 'Unread' }}
                                </span>
                                <h2 class="text-xl font-semibold mt-4 dark:text-white">
                                    {{ $contact->subject }}
                                </h2>
                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    <p>From: <span class="font-medium">{{ $contact->name }}
                                            &lt;{{ $contact->email }}&gt;</span></p>
                                    <p>Received: {{ $contact->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Body -->
                    <div class="p-6">
                        <div class="prose max-w-none dark:prose-invert">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <!-- Attachments -->
                    @if ($contact->attachments && count($contact->attachments) > 0)
                        <div class="border-t dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold mb-4 dark:text-white">Attachments</h3>
                            <div class="flex flex-wrap gap-4">
                                @foreach ($contact->attachments as $attachment)
                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                        class="flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                        <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                        <span class="text-sm dark:text-gray-300">{{ $attachment->original_name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Reply History -->
                    @if ($contact->replied_at)
                        <div class="border-t dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold mb-4 dark:text-white">Reply History</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div
                                    class="flex justify-between items-center mb-2 text-sm text-gray-600 dark:text-gray-300">
                                    <span>Replied on {{ $contact->replied_at->format('M d, Y H:i') }}</span>
                                    <span>By {{ $contact->replied_by_user->name }}</span>
                                </div>
                                <div class="prose max-w-none dark:prose-invert">
                                    {!! nl2br(e($contact->reply_message)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Reply Form -->
                    <div class="border-t dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-white">Send Reply</h3>
                        <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <textarea name="reply_message" rows="6" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="Type your reply here..."></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Send Reply
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
            <div class="bg-white dark:bg-slate-800 rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Confirm Deletion</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete this message?</p>
                <div class="flex justify-end gap-4">
                    <button id="cancel-delete"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <form id="delete-form" method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition ease-in-out duration-150">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteModal = document.getElementById('delete-modal');
                const deleteBtn = document.getElementById('delete-btn');
                const cancelBtn = document.getElementById('cancel-delete');

                deleteBtn.addEventListener('click', () => deleteModal.classList.remove('hidden'));
                cancelBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));
            });
        </script>
    </main>
@endsection

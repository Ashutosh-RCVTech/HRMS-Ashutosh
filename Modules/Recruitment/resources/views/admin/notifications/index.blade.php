@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h2>
                <div class="flex space-x-4">
                    @if ($notifications->isNotEmpty())
                        <form action="{{ route('admin.notifications.markAllAsRead') }}" method="POST" class="inline">
                            @csrf
                            @method('POST')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#bf125d] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#a01050] focus:bg-[#a01050] active:bg-[#8f0f47] focus:outline-none focus:ring-2 focus:ring-[#bf125d] focus:ring-offset-2 transition ease-in-out duration-150">
                                Mark All as Read
                            </button>
                        </form>
                        <form action="{{ route('admin.notifications.destroyAll') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Clear All
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @if ($notifications->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">No notifications found.</p>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($notifications as $notification)
                        <div
                            class="p-4 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 dark:text-white">
                                        {{ $notification->data['message'] ?? 'No message content' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    @if (!$notification->read_at)
                                        <form action="{{ route('admin.notifications.markAsRead', $notification->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                class="text-[#bf125d] hover:text-[#a01050] focus:outline-none">
                                                <span class="sr-only">Mark as read</span>
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 focus:outline-none">
                                            <span class="sr-only">Delete notification</span>
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif

            @if (session('status'))
                <div
                    class="mt-4 p-4 rounded-md {{ session('status') === 'notification-marked-read' || session('status') === 'all-notifications-marked-read' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
                    <p class="text-sm">
                        @switch(session('status'))
                            @case('notification-marked-read')
                                Notification marked as read.
                            @break

                            @case('all-notifications-marked-read')
                                All notifications marked as read.
                            @break

                            @case('notification-deleted')
                                Notification deleted.
                            @break

                            @case('all-notifications-deleted')
                                All notifications cleared.
                            @break
                        @endswitch
                    </p>
                </div>
            @endif
        </div>
    </main>
@endsection

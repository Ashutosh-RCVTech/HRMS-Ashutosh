@extends('layouts.admin')

@section('title', 'Contact Messages - Admin Dashboard')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Contact Messages</h1>
                </div>

                <!-- Filters & Search -->
                <div class="mb-8">
                    <form action="{{ route('admin.contacts.index') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search messages..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                        </div>

                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Messages</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                            </select>
                        </div>

                        <div>
                            <label for="sort_order"
                                class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Sort By</label>
                            <select name="sort_order" id="sort_order"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Newest First
                                </option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Oldest First
                                </option>
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Apply Filters
                            </button>
                            @if (request()->hasAny(['search', 'status', 'sort_order']))
                                <a href="{{ route('admin.contacts.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Messages Table -->
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                    <table class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    <input type="checkbox" id="select-all" class="rounded dark:bg-gray-700">
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Subject</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                            @forelse($contacts as $contact)
                                <tr
                                    class="{{ $contact->is_read ? '' : 'bg-blue-50 dark:bg-gray-700' }} hover:bg-gray-400 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="selected_contacts[]" value="{{ $contact->id }}"
                                            class="contact-checkbox rounded dark:bg-gray-700">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $contact->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $contact->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ Str::limit($contact->subject, 30) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $contact->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $contact->is_read
                                        ? 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200'
                                        : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                            {{ $contact->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                                class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                View
                                            </a>
                                            <button type="button" data-id="{{ $contact->id }}"
                                                data-read="{{ $contact->is_read ? 'true' : 'false' }}"
                                                class="toggle-read-btn inline-flex items-center px-3 py-1 {{ $contact->is_read ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring focus:ring-opacity-20 transition ease-in-out duration-150">
                                                {{ $contact->is_read ? 'Mark Unread' : 'Mark Read' }}
                                            </button>
                                            <button type="button" data-id="{{ $contact->id }}"
                                                class="delete-btn inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                        No contact messages found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $contacts->appends(request()->query())->links() }}
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
                    <form id="delete-form" method="POST">
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
                // Toggle read/unread status
                document.querySelectorAll('.toggle-read-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const isRead = this.dataset.read === 'true';

                        fetch(`/admin/contacts/${id}/toggle-read`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update button appearance
                                    this.textContent = data.is_read ? 'Mark Unread' : 'Mark Read';
                                    this.dataset.read = data.is_read;
                                    this.classList.toggle('bg-yellow-500', data.is_read);
                                    this.classList.toggle('bg-green-500', !data.is_read);
                                    this.classList.toggle('hover:bg-yellow-600', data.is_read);
                                    this.classList.toggle('hover:bg-green-600', !data.is_read);

                                    // Update row styling
                                    const row = this.closest('tr');
                                    row.classList.toggle('bg-blue-50', !data.is_read);
                                    row.classList.toggle('dark:bg-gray-700', !data.is_read);

                                    // Update status badge
                                    const statusBadge = row.querySelector('td:nth-child(6) span');
                                    statusBadge.textContent = data.is_read ? 'Read' : 'Unread';
                                    statusBadge.classList.toggle('bg-gray-200', data.is_read);
                                    statusBadge.classList.toggle('dark:bg-gray-600', data.is_read);
                                    statusBadge.classList.toggle('bg-blue-100', !data.is_read);
                                    statusBadge.classList.toggle('dark:bg-blue-900', !data.is_read);
                                }
                            });
                    });
                });

                // Delete confirmation modal
                const deleteModal = document.getElementById('delete-modal');
                const deleteForm = document.getElementById('delete-form');

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        deleteForm.action = `/admin/contacts/${id}`;
                        deleteModal.classList.remove('hidden');
                    });
                });

                document.getElementById('cancel-delete').addEventListener('click', () => {
                    deleteModal.classList.add('hidden');
                });

                // Bulk selection
                const selectAll = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('.contact-checkbox');
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

                selectAll.addEventListener('change', () => {
                    checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
                    updateBulkDeleteButton();
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateBulkDeleteButton);
                });

                function updateBulkDeleteButton() {
                    const selected = document.querySelectorAll('.contact-check box:checked').length;
                    bulkDeleteBtn.disabled = selected === 0;
                }

                // Bulk delete functionality
                bulkDeleteBtn.addEventListener('click', function() {
                    const selectedIds = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value);

                    if (selectedIds.length > 0 && confirm(
                            `Are you sure you want to delete ${selectedIds.length} messages? This action cannot be undone.`
                            )) {
                        fetch('{{ route('admin.contacts.bulk-delete') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content
                                },
                                body: JSON.stringify({
                                    ids: selectedIds
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                }
                            });
                    }
                });
            });
        </script>
    </main>
@endsection

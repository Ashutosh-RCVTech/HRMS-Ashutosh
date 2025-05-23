@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sm:mb-0">Permission Management</h2>
                <button onclick="openCreateModal()"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Permission
                </button>
            </div>

            <!-- Search Section -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search permissions..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Permissions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($permissions as $permission)
                    <div
                        class="bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-200 dark:border-gray-600">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $permission->name }}
                                </h3>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                {{ $permission->description }}
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($permission->roles->take(3) as $role)
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs rounded-full">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                                @if ($permission->roles->count() > 3)
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs rounded-full">
                                        +{{ $permission->roles->count() - 3 }} more
                                    </span>
                                @endif
                            </div>
                            <div class="flex justify-end gap-2">
                                <button onclick="editPermission({{ $permission->id }})"
                                    class="px-3 py-1 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    Edit
                                </button>
                                <button onclick="deletePermission({{ $permission->id }})"
                                    class="px-3 py-1 text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Create/Edit Permission Modal -->
        <div id="permissionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white" id="modalTitle">Create Permission</h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="permissionForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permission
                                Name</label>
                            <input type="text" name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Move these functions outside of the DOMContentLoaded event listener
        function editPermission(permissionId) {
            document.getElementById('modalTitle').textContent = 'Edit Permission';
            // Fetch permission data and populate form
            fetch(`/permissions/${permissionId}`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('permissionForm');
                    form.name.value = data.name;
                    form.description.value = data.description;
                    document.getElementById('permissionModal').classList.remove('hidden');
                    document.getElementById('permissionModal').classList.add('flex');
                });
        }

        function deletePermission(permissionId) {
            if (confirm('Are you sure you want to delete this permission?')) {
                fetch(`/permissions/${permissionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create Permission';
            document.getElementById('permissionForm').reset();
            document.getElementById('permissionModal').classList.remove('hidden');
            document.getElementById('permissionModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('permissionModal').classList.remove('flex');
            document.getElementById('permissionModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const permissionCards = document.querySelectorAll('.grid > div');

                permissionCards.forEach(card => {
                    const permissionName = card.querySelector('h3').textContent.toLowerCase();
                    const permissionDescription = card.querySelector('p').textContent.toLowerCase();

                    if (permissionName.includes(searchTerm) || permissionDescription.includes(
                            searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Form submission handler
            document.getElementById('permissionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const permissionId = this.dataset.permissionId;
                const url = permissionId ? `/permissions/${permissionId}` : '/permissions';
                const method = permissionId ? 'PUT' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            closeModal();
                            location.reload();
                        }
                    });
            });
        });
    </script>
@endsection

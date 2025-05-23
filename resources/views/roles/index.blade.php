@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Role Management</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create and manage roles with specific permissions.</p>
                
                <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Roles define what actions users can perform in the system. Each role has a set of permissions.
                </div>
            </div>

            <!-- Search and Actions Bar -->
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-1 items-center space-x-4">
                    <div class="w-full max-w-lg">
                        <label for="search" class="sr-only">Search roles</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="search" id="search" class="block w-full rounded-lg border border-gray-200 bg-white pl-10 pr-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400" placeholder="Search roles...">
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="mr-2 text-sm font-medium text-gray-900 dark:text-white">Sort by:</span>
                        <select id="sort" class="rounded-lg border border-gray-200 bg-white py-2 pl-3 pr-8 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <option value="name">Name</option>
                            <option value="users">Users</option>
                            <option value="created">Created</option>
                        </select>
                    </div>

                    <button type="button" onclick="openCreateModal()" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Role
                    </button>
                </div>
            </div>

            <!-- Roles List -->
            <div class="grid gap-6">
                @foreach($roles as $role)
                <div class="relative rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $role->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $role->description }}</p>
                            
                            <div class="mt-4 flex items-center space-x-4">
                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $role->users_count }} Users</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Created {{ $role->created_at->format('M d, Y') }}</span>
                                </div>

                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Updated by {{ $role->updated_by }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $role->permissions_count }} Permissions
                                </span>
                            </div>
                        </div>

                        <div class="relative">
                            <button onclick="toggleDropdown('{{ $role->id }}')" class="inline-flex items-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>

                            <div id="dropdown-{{ $role->id }}" class="absolute right-0 mt-2 hidden w-44 rounded-lg bg-white shadow-lg dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                    <li>
                                        <button onclick="editRole('{{ $role->id }}')" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </button>
                                    </li>
                                    <li>
                                        <button onclick="manageUsers('{{ $role->id }}', '{{ $role->name }}')" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Manage Users
                                        </button>
                                    </li>
                                    <li>
                                        <button onclick="deleteRole('{{ $role->id }}')" class="flex w-full items-center px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Create/Edit Role Modal -->
    <div id="roleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle dark:bg-gray-800">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <h3 id="modalTitle" class="text-lg font-medium leading-6 text-gray-900 dark:text-white"></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Define the role's permissions to control user access levels.</p>
                    </div>

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="details-tab" data-tabs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="permissions-tab" data-tabs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="false">Permissions</button>
                            </li>
                        </ul>
                    </div>

                    <div id="tabContent">
                        <form id="roleForm">
                            <!-- Details Tab -->
                            <div class="block" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="space-y-4">
                                    <div>
                                        <label for="roleName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="roleName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Administrator, Editor, Viewer" required>
                                    </div>

                                    <div>
                                        <label for="roleDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea name="description" id="roleDescription" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Brief description of the role's purpose and access level"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions Tab -->
                            <div class="hidden" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                                <div class="mb-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Selected Permissions:</span>
                                            <span id="selectedPermissionsCount" class="text-sm font-medium text-blue-600">0</span>
                                        </div>
                                        <button type="button" onclick="clearAllPermissions()" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">Clear All</button>
                                    </div>
                                    <div class="mt-2 relative">
                                        <input type="text" id="searchPermissions" class="block w-full rounded-md border-gray-300 pl-10 pr-3 py-2 text-sm placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search permissions...">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4 max-h-[400px] overflow-y-auto">
                                    @foreach($permissions->groupBy('category') as $category => $categoryPermissions)
                                    <div class="permission-group">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($category) }}</span>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ count($categoryPermissions) }}</span>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer category-toggle" data-category="{{ $category }}">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                        <div class="ml-6 space-y-2">
                                            @foreach($categoryPermissions as $permission)
                                            <div class="flex items-center justify-between py-2">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $permission->name }}</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->description }}</span>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer permission-checkbox" name="permissions[]" value="{{ $permission->id }}" data-category="{{ $category }}">
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Users Modal -->
    <div id="manageUsersModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle dark:bg-gray-800">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Manage Users for <span id="roleNameTitle"></span></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add or remove users from this role.</p>
                    </div>

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                            <li class="mr-2">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="current-users-tab" data-tabs-target="#current-users" type="button" role="tab" aria-controls="current-users" aria-selected="true">Current Users (1)</button>
                            </li>
                            <li class="mr-2">
                                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="assign-users-tab" data-tabs-target="#assign-users" type="button" role="tab" aria-controls="assign-users" aria-selected="false">Assign Users (7)</button>
                            </li>
                        </ul>
                    </div>

                    <div id="usersTabContent">
                        <!-- Current Users Tab -->
                        <div class="block" id="current-users" role="tabpanel" aria-labelledby="current-users-tab">
                            <div class="relative">
                                <input type="text" id="searchCurrentUsers" class="block w-full rounded-md border-gray-300 pl-10 pr-3 py-2 text-sm placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search users...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-4 space-y-2 max-h-[400px] overflow-y-auto">
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">John Doe</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">john@example.com</p>
                                        </div>
                                    </div>
                                    <button type="button" class="text-red-600 hover:text-red-700">
                                        <span class="sr-only">Remove user</span>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Assign Users Tab -->
                        <div class="hidden" id="assign-users" role="tabpanel" aria-labelledby="assign-users-tab">
                            <div class="relative">
                                <input type="text" id="searchAssignUsers" class="block w-full rounded-md border-gray-300 pl-10 pr-3 py-2 text-sm placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search users to assign...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-4 space-y-2 max-h-[400px] overflow-y-auto">
                                @foreach(['Jane Smith', 'Sarah Johnson', 'Mike Brown', 'Alex Turner', 'Lisa Wong'] as $user)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ strtolower(str_replace(' ', '', $user)) }}@example.com</p>
                                        </div>
                                    </div>
                                    <button type="button" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        Assign
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="closeManageUsersModal()" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function toggleDropdown(roleId) {
    const dropdown = document.getElementById(`dropdown-${roleId}`);
    dropdown.classList.toggle('hidden');
}

function openCreateModal() {
    const modal = document.getElementById('roleModal');
    const modalTitle = document.getElementById('modalTitle');
    const roleForm = document.getElementById('roleForm');
    
    // Reset form
    roleForm.reset();
    roleForm.removeAttribute('data-role-id');
    clearAllPermissions();
    
    modalTitle.textContent = 'Create New Role';
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('roleModal');
    modal.classList.add('hidden');
}

function editRole(roleId) {
    const modal = document.getElementById('roleModal');
    const modalTitle = document.getElementById('modalTitle');
    const roleForm = document.getElementById('roleForm');
    
    // Set form in edit mode
    roleForm.dataset.roleId = roleId;
    
    // Fetch role data
    fetch(`/admin/roles/${roleId}`)
        .then(response => response.json())
        .then(data => {
            // Populate form fields
            document.getElementById('roleName').value = data.name;
            document.getElementById('roleDescription').value = data.description;
            
            // Clear existing permissions
            clearAllPermissions();
            
            // Check corresponding permissions
            data.permissions.forEach(permission => {
                const checkbox = document.querySelector(`input[value="${permission.id}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            
            updateSelectedPermissionsCount();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load role data');
        });
    
    modalTitle.textContent = 'Edit Role';
    modal.classList.remove('hidden');
}

function manageUsers(roleId, roleName) {
    const modal = document.getElementById('manageUsersModal');
    const roleNameTitle = document.getElementById('roleNameTitle');
    roleNameTitle.textContent = roleName;
    modal.classList.remove('hidden');
    
    // Store the role ID for later use
    modal.dataset.roleId = roleId;
    
    // Load current users
    loadCurrentUsers(roleId);
    
    // Load available users
    loadAvailableUsers();
    
    // Initialize tabs
    document.getElementById('current-users-tab').click();
}

function loadCurrentUsers(roleId) {
    const container = document.querySelector('#current-users .max-h-\\[400px\\]');
    
    fetch(`/admin/roles/${roleId}/users`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the tab count
                document.getElementById('current-users-tab').textContent = `Current Users (${data.total})`;
                
                // Clear existing content
                container.innerHTML = '';
                
                // Add users to the container
                data.users.forEach(user => {
                    container.innerHTML += `
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${user.name}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">${user.email}</p>
                                </div>
                            </div>
                            <button type="button" onclick="removeUser(${user.id})" class="text-red-600 hover:text-red-700">
                                <span class="sr-only">Remove user</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load current users');
        });
}

function loadAvailableUsers() {
    const container = document.querySelector('#assign-users .max-h-\\[400px\\]');
    
    fetch('/admin/roles/available-users')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the tab count
                document.getElementById('assign-users-tab').textContent = `Assign Users (${data.total})`;
                
                // Clear existing content
                container.innerHTML = '';
                
                // Add users to the container
                data.users.forEach(user => {
                    container.innerHTML += `
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${user.name}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">${user.email}</p>
                                </div>
                            </div>
                            <button type="button" onclick="assignUser(${user.id})" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Assign
                            </button>
                        </div>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load available users');
        });
}

function assignUser(userId) {
    const roleId = document.getElementById('manageUsersModal').dataset.roleId;
    
    fetch(`/admin/roles/${roleId}/users/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh both user lists
            loadCurrentUsers(roleId);
            loadAvailableUsers();
        } else {
            throw new Error(data.message || 'Failed to assign user');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Failed to assign user');
    });
}

function removeUser(userId) {
    if (!confirm('Are you sure you want to remove this user from the role?')) {
        return;
    }
    
    const roleId = document.getElementById('manageUsersModal').dataset.roleId;
    
    fetch(`/admin/roles/${roleId}/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh both user lists
            loadCurrentUsers(roleId);
            loadAvailableUsers();
        } else {
            throw new Error(data.message || 'Failed to remove user');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Failed to remove user');
    });
}

function closeManageUsersModal() {
    const modal = document.getElementById('manageUsersModal');
    modal.classList.add('hidden');
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role?')) {
        // Handle role deletion
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target) && !event.target.closest('button')) {
            dropdown.classList.add('hidden');
        }
    });
});

// Tab functionality
const tabButtons = document.querySelectorAll('[role="tab"]');
const tabPanels = document.querySelectorAll('[role="tabpanel"]');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Deactivate all tabs
        tabButtons.forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('border-transparent');
            btn.setAttribute('aria-selected', 'false');
        });
        tabPanels.forEach(panel => panel.classList.add('hidden'));

        // Activate clicked tab
        button.classList.add('text-blue-600', 'border-blue-600');
        button.classList.remove('border-transparent');
        button.setAttribute('aria-selected', 'true');

        // Show corresponding panel
        const panelId = button.getAttribute('aria-controls');
        document.getElementById(panelId).classList.remove('hidden');
    });
});

// Permission search functionality
const searchPermissions = document.getElementById('searchPermissions');
searchPermissions.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const permissionGroups = document.querySelectorAll('.permission-group');

    permissionGroups.forEach(group => {
        const groupText = group.textContent.toLowerCase();
        group.style.display = groupText.includes(searchTerm) ? 'block' : 'none';
    });
});

// Category toggle functionality
document.querySelectorAll('.category-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const category = this.dataset.category;
        const isChecked = this.checked;
        document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`).forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateSelectedPermissionsCount();
    });
});

// Update selected permissions count
function updateSelectedPermissionsCount() {
    const selectedCount = document.querySelectorAll('input[name="permissions[]"]:checked').length;
    document.getElementById('selectedPermissionsCount').textContent = selectedCount;
}

// Clear all permissions
function clearAllPermissions() {
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateSelectedPermissionsCount();
}

// Add event listeners to permission checkboxes
document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedPermissionsCount);
});

// Initialize tabs
document.getElementById('details-tab').click();

// Users tab functionality
const userTabButtons = document.querySelectorAll('#manageUsersModal [role="tab"]');
const userTabPanels = document.querySelectorAll('#manageUsersModal [role="tabpanel"]');

userTabButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Deactivate all tabs
        userTabButtons.forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('border-transparent');
            btn.setAttribute('aria-selected', 'false');
        });
        userTabPanels.forEach(panel => panel.classList.add('hidden'));

        // Activate clicked tab
        button.classList.add('text-blue-600', 'border-blue-600');
        button.classList.remove('border-transparent');
        button.setAttribute('aria-selected', 'true');

        // Show corresponding panel
        const panelId = button.getAttribute('aria-controls');
        document.getElementById(panelId).classList.remove('hidden');
    });
});

// Search functionality for users
['searchCurrentUsers', 'searchAssignUsers'].forEach(searchId => {
    const searchInput = document.getElementById(searchId);
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const userList = searchInput.closest('[role="tabpanel"]').querySelectorAll('.flex.items-center.justify-between');
        
        userList.forEach(userItem => {
            const userName = userItem.querySelector('.font-medium').textContent.toLowerCase();
            const userEmail = userItem.querySelector('.text-gray-500').textContent.toLowerCase();
            userItem.style.display = userName.includes(searchTerm) || userEmail.includes(searchTerm) ? 'flex' : 'none';
        });
    });
});

// Form submission handling
document.getElementById('roleForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const roleId = this.dataset.roleId; // For edit mode
    const isEdit = !!roleId;
    
    // Get all selected permissions
    const selectedPermissions = [];
    document.querySelectorAll('input[name="permissions[]"]:checked').forEach(checkbox => {
        selectedPermissions.push(parseInt(checkbox.value)); // Convert to integer
    });
    
    // Create the request payload
    const payload = {
        name: formData.get('name'),
        description: formData.get('description'),
        permissions: selectedPermissions
    };

    try {
        const response = await fetch(`/admin/roles${isEdit ? `/${roleId}` : ''}`, {
            method: isEdit ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Failed to save role');
        }
        
        // Show success message
        alert(isEdit ? 'Role updated successfully!' : 'Role created successfully!');
        
        // Close modal and refresh page
        closeModal();
        window.location.reload();
        
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Failed to save role. Please try again.');
    }
});
</script>
@endsection
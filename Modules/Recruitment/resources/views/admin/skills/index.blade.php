@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white rounded-xl shadow-lg">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Skills</h1>
                    <a href="{{ route('admin.skills.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Add Skill
                    </a>
                </div>

                <!-- Search Section -->
                <div class="mb-6">
                    <form id="search-form" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" id="search" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-slate-800 dark:border-gray-600 dark:text-white"
                                placeholder="Search skills..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.skills.index') }}" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Skills Table -->
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                    <table class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    No.
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700" id="skills-table-body">
                            @include('recruitment::admin.skills.partials.skills-table', [
                                'skills' => $skills,
                            ])
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $skills->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Delete skill function
            window.deleteSkill = function(skillId) {
                if (confirm('Are you sure you want to delete this skill?')) {
                    fetch(`/admin/skills/${skillId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            }

            // Handle search form submission
            const searchForm = document.getElementById('search-form');
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchInput = document.getElementById('search');
                const searchValue = searchInput.value.trim();
                
                if (searchValue) {
                    window.location.href = `{{ route('admin.skills.index') }}?search=${encodeURIComponent(searchValue)}`;
                } else {
                    window.location.href = `{{ route('admin.skills.index') }}`;
                }
            });
        });
    </script>
@endsection

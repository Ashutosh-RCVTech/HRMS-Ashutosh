@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">


            <div class="container mx-auto px-4 py-8">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold">Placement Drive</h1>
                        <a href="{{ route('admin.placement.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Add New Drive
                        </a>
                    </div>


                    <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                        <table
                            class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800  dark:text-white">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Name</th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Posted Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                                @forelse ($placements as $placement)
                                    <tr class="hover:bg-gray-400 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $placement->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            {{ $placement->created_at->format('M d, Y') }}</td>


                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <label for="toggle{{ $placement->id }}"
                                                    class="relative flex items-center cursor-pointer">
                                                    <input type="checkbox" id="toggle{{ $placement->id }}" class="sr-only"
                                                        {{ $placement->status ? 'checked' : '' }}
                                                        onclick="confirmStatusChange({{ $placement->id }}, '{{ $placement->status ? 'Deactivate' : 'Activate' }}')">
            
                                                    <div
                                                        class="w-12 h-6 bg-green-500 rounded-full transition duration-300
                                                           {{ $placement->status ? 'bg-green-500' : 'bg-red-500' }}">
                                                    </div>
            
                                                    <div
                                                        class="absolute left-1 top-1 mt-1 w-4 h-4 bg-white rounded-full shadow-md transition 
                                                   {{ $placement->status ? 'translate-x-6' : '' }}">
                                                    </div>
                                                </label>
                                                {{-- <a href="{{ route('admin.placement.edit', $placement->id) }}"
                                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Send Email
                                                </a> --}}
                                                <a href="{{ route('admin.placement.edit', $placement->id) }}"
                                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.placement.show', $placement->id) }}"
                                                    class="inline-flex items-center px-3 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:outline-none focus:border-orange-700 focus:ring focus:ring-orange-200 active:bg-orange-800 transition ease-in-out duration-150">
                                                    <svg fill="#eee" class="w-4 h-4 mr-2 dark:text-white" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M19,13 C20.6568542,13 22,14.3431458 22,16 L22,19 C22,20.6568542 20.6568542,22 19,22 L16,22 C14.3431458,22 13,20.6568542 13,19 L13,16 C13,14.3431458 14.3431458,13 16,13 L19,13 Z M8,13 C9.65685425,13 11,14.3431458 11,16 L11,19 C11,20.6568542 9.65685425,22 8,22 L5,22 C3.34314575,22 2,20.6568542 2,19 L2,16 C2,14.3431458 3.34314575,13 5,13 L8,13 Z M19,15 L16,15 C15.4477153,15 15,15.4477153 15,16 L15,19 C15,19.5522847 15.4477153,20 16,20 L19,20 C19.5522847,20 20,19.5522847 20,19 L20,16 C20,15.4477153 19.5522847,15 19,15 Z M8,15 L5,15 C4.44771525,15 4,15.4477153 4,16 L4,19 C4,19.5522847 4.44771525,20 5,20 L8,20 C8.55228475,20 9,19.5522847 9,19 L9,16 C9,15.4477153 8.55228475,15 8,15 Z M19,2 C20.6568542,2 22,3.34314575 22,5 L22,8 C22,9.65685425 20.6568542,11 19,11 L5,11 C3.34314575,11 2,9.65685425 2,8 L2,5 C2,3.34314575 3.34314575,2 5,2 L19,2 Z M19,4 L5,4 C4.44771525,4 4,4.44771525 4,5 L4,8 C4,8.55228475 4.44771525,9 5,9 L19,9 C19.5522847,9 20,8.55228475 20,8 L20,5 C20,4.44771525 19.5522847,4 19,4 Z" />
                                                    </svg>
                                                    View
                                                </a>
                                                <form action="{{ route('admin.placement.delete', $placement->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">

                                                            
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                            No Placement Drives found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4 p-4">
                            {{ $placements->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>



    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black  bg-opacity-50 hidden">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg">
            <div
                class="flex px-6 py-3 bg-gray-200 dark:bg-slate-800 gap-4 rounded-lg text-lg font-semibold items-center justify-between">
                <h2 id="modalTitle" class="">Confirm Status Change</h2>
            </div>

            <p id="confirmText" class="mb-4 px-6 py-1"></p>
            <div class="flex justify-end gap-4 px-6 pt-2 pb-4">
                <button onclick="closeModal()" class="px-4 py-1 bg-gray-500 text-white rounded">Cancel</button>
                <form id="statusForm" method="POST" class="px-0 py-0 m-0">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="placement_id" id="placementId">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmStatusChange(placementId, action) {
            document.getElementById("confirmText").innerText = `Are you sure you want to ${action} this drive?`;
            document.getElementById("placementId").value = placementId;
            document.getElementById("statusForm").action = `/admin/placement/${placementId}/updatestatus`;
            document.getElementById("confirmModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("confirmModal").classList.add("hidden");
        }
    </script>
@endsection
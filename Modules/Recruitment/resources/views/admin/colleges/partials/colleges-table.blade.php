<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">College</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
            @forelse($colleges as $college)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            @if($college->logo)
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $college->logo) }}" alt="{{ $college->name }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-[#bf125d] flex items-center justify-center text-white font-bold text-xl">
                                    {{ strtoupper(substr($college->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $college->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Registered {{ $college->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $college->email }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $college->phone }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $college->city }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $college->state }}</div>
                </td>
                <td class="px-6 py-4">
                    <button onclick="toggleCollegeStatus('{{ $college->id }}')" 
                        class="status-badge px-3 py-1 rounded-full text-sm font-medium {{ $college->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        {{ $college->is_active ? 'Active' : 'Inactive' }}
                    </button>
                </td>
                <td class="px-6 py-4 text-sm font-medium">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.colleges.show', $college) }}" class="text-[#bf125d] hover:text-[#a01050]">View</a>
                        <form action="{{ route('admin.colleges.destroy', $college) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this college?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No colleges found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
    {{ $colleges->links() }}
</div> 
@props(['deadlines'])

<div class="bg-white rounded-xl p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-4">Upcoming Deadlines</h3>
    <div class="space-y-4">
        {{-- @forelse($deadlines as $deadline)
        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
            <div>
                <h4 class="font-medium text-gray-900">{{ $deadline->title }}</h4>
                <p class="text-sm text-gray-500">
                    {{ $deadline->application_deadline->format('M d, Y') }}
                </p>
            </div>
            <span class="text-sm {{ $deadline->application_deadline->isToday() ? 'text-red-600' : 'text-gray-500' }}">
                {{ $deadline->application_deadline->diffForHumans() }}
            </span>
        </div>
        @empty
        <div class="text-center text-gray-500 py-4">
            No upcoming deadlines
        </div>
        @endforelse --}}
    </div>
</div>
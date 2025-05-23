@props(['metric'])

<div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-shadow">
    <h3 class="text-gray-500 text-sm font-medium">{{ $metric['title'] }}</h3>
    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $metric['value'] }}</p>
    @isset($metric['trend'])
    <div class="mt-2 flex items-center text-sm {{ $metric['trend']['color'] }}">
        {{ $metric['trend']['value'] }}
        @if($metric['trend']['direction'] === 'up')
        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                clip-rule="evenodd" />
        </svg>
        @else
        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z"
                clip-rule="evenodd" />
        </svg>
        @endif
    </div>
    @endisset
</div>
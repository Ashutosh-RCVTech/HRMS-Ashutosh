<div class="mb-6">
    <h4 class="font-medium mb-3 dark:text-white">{{ $title }}</h4>
    <div class="space-y-3">
        @foreach($options as $option)
        <label class="flex items-center gap-3 cursor-pointer group">
            <div class="relative"> 
                <input type="checkbox" name="filters[{{ Str::slug($title, '_') }}][]" value="{{ $option['label'] }}"
                    class="peer hidden filter-checkbox" {{ in_array($option['label'], request()->input('filters.' .
                Str::slug($title, '_'), [])) ? 'checked' : '' }}>
                <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                   peer-checked:border-primary-500 peer-checked:bg-primary-500
                   group-hover:border-primary-500 transition-colors duration-200">
                    <svg class="w-full h-full text-white scale-0 peer-checked:scale-100 transition-transform duration-200"
                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 10l3 3 6-6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <span class="text-gray-700 dark:text-white group-hover:text-primary-500 transition-colors duration-200">
                {{ $option['label'] }}
            </span>
        </label>
        @endforeach

    </div>
</div>
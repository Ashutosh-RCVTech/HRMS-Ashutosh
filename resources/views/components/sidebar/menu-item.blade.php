<!-- @props([
    'icon' => '',
    'label' => '',
    'route' => '',
    'subItems' => [],
])

@php
    $isActive =
        request()->routeIs($route) ||
        collect($subItems)
            ->pluck('route')
            ->contains(function ($subRoute) {
                return request()->routeIs($subRoute);
            });
@endphp

<li class="relative list-none text-bgray-900 dark:text-white mb-1">
    @if (count($subItems) > 0)
        {{-- Parent Menu Item with Submenu --}}
        <button x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" @click="open = !open"
            class="flex items-center w-full p-3 rounded-lg transition-all duration-200 
                  {{ $isActive ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <div class="flex items-center flex-1">
                <div class="w-8 h-8 flex items-center justify-center">
                    <x-sidebar.icon :name="$icon" />
                </div>
                <span class="ml-3 text-sm font-medium">
                    {{ $label }}
                </span>
            </div>
            {{-- Arrow that rotates based on state, not hover --}}
            <svg class="w-4 h-4 ml-2 transition-transform duration-200"
                :class="{ 'rotate-180': open, 'rotate-0': !open }" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        {{-- Submenu that toggles via click, not hover --}}
        <ul x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="pl-4 py-1 ml-6 border-l border-gray-200 dark:border-gray-700">
            @foreach ($subItems as $subItem)
                @php
                    $isSubActive = request()->routeIs($subItem['route']);
                @endphp
                <li class="relative">
                    <a href="{{ route($subItem['route']) }}"
                        class="flex items-center py-2 px-3 text-sm rounded-md
                              {{ $isSubActive
                                  ? 'text-primary-600 bg-primary-50 dark:text-primary-400 dark:bg-gray-800'
                                  : 'text-gray-600 dark:text-gray-300 hover:text-primary-600 hover:bg-gray-50 dark:hover:text-primary-400 dark:hover:bg-gray-800' }}
                              transition-colors duration-200">
                        <span
                            class="h-1.5 w-1.5 rounded-full mr-2 {{ $isSubActive ? 'bg-primary-500' : 'bg-gray-400' }}"></span>
                        {{ $subItem['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        {{-- Single Menu Item --}}
        <a href="{{ route($route) }}"
            class="flex items-center w-full p-3 rounded-lg transition-all duration-200
                  {{ $isActive ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <div class="w-8 h-8 flex items-center justify-center">
                <x-sidebar.icon :name="$icon" />
            </div>
            <span class="ml-3 text-sm font-medium">
                {{ $label }}
            </span>
        </a>
    @endif
</li> -->

@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        System Settings
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Configure your application settings and preferences.
                    </p>

                    <form method="post" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site
                                Name</label>
                            <input type="text" name="site_name" id="site_name"
                                value="{{ old('site_name', $settings['site_name']) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                            @error('site_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="site_description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Description</label>
                            <textarea name="site_description" id="site_description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">{{ old('site_description', $settings['site_description']) }}</textarea>
                            @error('site_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Email</label>
                            <input type="email" name="contact_email" id="contact_email"
                                value="{{ old('contact_email', $settings['contact_email']) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="timezone"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                            <select name="timezone" id="timezone"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                @foreach (timezone_identifiers_list() as $timezone)
                                    <option value="{{ $timezone }}"
                                        {{ old('timezone', $settings['timezone']) == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('timezone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date
                                Format</label>
                            <select name="date_format" id="date_format"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                <option value="Y-m-d"
                                    {{ old('date_format', $settings['date_format']) == 'Y-m-d' ? 'selected' : '' }}>
                                    YYYY-MM-DD</option>
                                <option value="d/m/Y"
                                    {{ old('date_format', $settings['date_format']) == 'd/m/Y' ? 'selected' : '' }}>
                                    DD/MM/YYYY</option>
                                <option value="m/d/Y"
                                    {{ old('date_format', $settings['date_format']) == 'm/d/Y' ? 'selected' : '' }}>
                                    MM/DD/YYYY</option>
                            </select>
                            @error('date_format')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="enable_registration" id="enable_registration" value="1"
                                {{ old('enable_registration', $settings['enable_registration']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#bf125d] shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700">
                            <label for="enable_registration" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable User Registration
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="enable_notifications" id="enable_notifications" value="1"
                                {{ old('enable_notifications', $settings['enable_notifications']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#bf125d] shadow-sm focus:border-[#bf125d] focus:ring-[#bf125d] dark:border-gray-600 dark:bg-gray-700">
                            <label for="enable_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable System Notifications
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#bf125d] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#a01050] focus:bg-[#a01050] active:bg-[#8f0f47] focus:outline-none focus:ring-2 focus:ring-[#bf125d] focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Settings
                            </button>

                            @if (session('status') === 'settings-updated')
                                <p class="text-sm text-gray-600 dark:text-gray-400">Settings saved successfully.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

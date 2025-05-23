@extends('layouts.admin')

@section('title', 'Create Client')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Create Client</h1>

                <form id="client_create_form" method="POST" action="{{ route('admin.clients.store') }}"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold">Basic Information</h2>

                            <!-- Company Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Company Name <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="Enter company name">
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div>
                                <label for="company_type"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Company Type <span class="text-red-500">*</span>
                                </label>
                                <select id="company_type" name="company_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="">Select Company Type</option>
                                    <option value="corporation"
                                        {{ old('company_type') == 'corporation' ? 'selected' : '' }}>Corporation</option>
                                    <option value="partnership"
                                        {{ old('company_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="sole_proprietorship"
                                        {{ old('company_type') == 'sole_proprietorship' ? 'selected' : '' }}>Sole
                                        Proprietorship</option>
                                    <option value="llc" {{ old('company_type') == 'llc' ? 'selected' : '' }}>LLC</option>
                                </select>
                                @error('company_type')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div>
                                <div>
                                    <label for="industry"
                                        class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                        Industry <span class="text-red-500">*</span>
                                    </label>
                                    <input id="industry" name="industry" type="text" value="{{ old('industry') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                        placeholder="Enter industry">
                                    @error('industry')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Website URL -->
                            <div>
                                <label for="website_url"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Website URL
                                </label>
                                <input id="website_url" name="website_url" type="url" value="{{ old('website_url') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="https://example.com">
                                @error('website_url')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Company Description
                                </label>
                                <textarea id="description" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    rows="3" placeholder="Enter company description">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold">Contact Information</h2>

                            <!-- Contact Person Name -->
                            <div>
                                <label for="contact_person_name"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Contact Person Name
                                </label>
                                <input id="contact_person_name" name="contact_person_name" type="text"
                                    value="{{ old('contact_person_name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="John Doe">
                                @error('contact_person_name')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Person Position -->
                            <div>
                                <label for="contact_person_position"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Contact Person Position
                                </label>
                                <input id="contact_person_position" name="contact_person_position" type="text"
                                    value="{{ old('contact_person_position') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="Manager">
                                @error('contact_person_position')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <label for="contact_email"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Contact Email <span class="text-red-500">*</span>
                                </label>
                                <input id="contact_email" name="contact_email" type="email"
                                    value="{{ old('contact_email') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="contact@example.com">
                                @error('contact_email')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <label for="contact_phone"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Contact Phone <span class="text-red-500">*</span>
                                </label>
                                <input id="contact_phone" name="contact_phone" type="tel"
                                    value="{{ old('contact_phone') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="+1234567890">
                                @error('contact_phone')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Address
                                </label>
                                <textarea id="address" name="address"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    rows="2" placeholder="Enter address">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold">Subscription Information</h2>

                            <!-- Subscription Tier -->
                            <div>
                                <label for="subscription_tier"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Subscription Tier <span class="text-red-500">*</span>
                                </label>
                                <select id="subscription_tier" name="subscription_tier" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="">Select Subscription Tier</option>
                                    <option value="1" {{ old('subscription_tier') == '1' ? 'selected' : '' }}>Basic
                                    </option>
                                    <option value="2" {{ old('subscription_tier') == '2' ? 'selected' : '' }}>Premium
                                    </option>
                                    <option value="3" {{ old('subscription_tier') == '3' ? 'selected' : '' }}>
                                        Enterprise</option>
                                </select>
                                @error('subscription_tier')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subscription Expiry -->
                            <div>
                                <label for="subscription_expiry"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Subscription Expiry Date
                                </label>
                                <input id="subscription_expiry" name="subscription_expiry" type="date"
                                    value="{{ old('subscription_expiry') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('subscription_expiry')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Media Upload Section -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold">Media Upload</h2>

                            <!-- Client Logo -->
                            <div>
                                <label for="client_logo"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Company Logo
                                </label>
                                <input type="file" name="client_logo" id="client_logo" accept="image/*"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <p class="text-xs text-gray-500 mt-1">Recommended size: 200x200px, Max size: 2MB</p>
                                @error('client_logo')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Banner Image -->
                            <div>
                                <label for="banner_image"
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                                    Banner Image
                                </label>
                                <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x300px, Max size: 5MB</p>
                                @error('banner_image')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Toggles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <div class="flex items-center">
                                <input id="is_active" name="is_active" type="checkbox" value="1"
                                    {{ old('is_active') ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-slate-800 dark:border-gray-700">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-white">
                                    Active
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Enable or disable client account</p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-slate-800 dark:border-gray-700">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-white">
                                    Featured
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Show client in featured sections</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between items-center mt-8">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Create Client
                        </button>
                        <a href="{{ route('admin.clients.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

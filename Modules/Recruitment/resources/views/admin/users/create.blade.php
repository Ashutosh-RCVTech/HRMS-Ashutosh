@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Create New User</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- User Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" class="form-input w-full" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" class="form-input w-full" required>
                    </div>
                    <!-- Add more user fields -->
                </div>
            </div>

            <!-- Profile Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Phone</label>
                        <input type="tel" name="phone" class="form-input w-full">
                    </div>
                    <!-- Add more profile fields -->
                </div>
            </div>

            <!-- Role Assignment -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Assign Roles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($roles as $role)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Create User
            </button>
        </form>
    </div>
@endsection

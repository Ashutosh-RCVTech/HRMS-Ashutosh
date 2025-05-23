<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full">
            <div class="p-4">
                <h2 class="text-2xl font-bold text-gray-800">Recruitment Portal</h2>
                <nav class="mt-8">
                    <x-organization.nav-link href="{{ route('organization.dashboard') }}" icon="dashboard">
                        Dashboard
                    </x-organization.nav-link>
                    <x-organization.nav-link href="{{ route('jobs.index') }}" icon="briefcase">
                        Job Postings
                    </x-organization.nav-link>
                    <x-organization.nav-link href="{{ route('organization.candidates') }}" icon="users">
                        Candidates
                    </x-organization.nav-link>
                    <x-organization.nav-link href="{{ route('organization.applications') }}" icon="document-text">
                        Applications
                    </x-organization.nav-link>
                    <x-organization.nav-link href="{{ route('clients.index') }}" icon="office-building">
                        Clients
                    </x-organization.nav-link>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <!-- Notifications & Profile -->
                </div>
            </header>

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @vite(['resources/js/organization.js'])
</body>
</html>

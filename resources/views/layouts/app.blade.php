<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Client Service Tracker') }} - @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="hidden md:flex md:flex-col w-64 bg-slate-900 text-slate-100">
        <div class="h-16 flex items-center px-6 border-b border-slate-700">
            <span class="font-semibold text-lg">
                Client Service Tracker
            </span>
        </div>

    <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
        <a href="{{ route('dashboard') }}"
        class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            Dashboard
        </a>
        <a href="{{ route('clients.index') }}"
        class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            Clients
        </a>
        <a href="#"
        class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            Services
        </a>
        <a href="#"
        class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            Interaction Logs
        </a>
        <a href="#"
        class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            Reports
        </a>
    </nav>


        <div class="px-4 py-4 border-t border-slate-700 text-xs text-slate-400">
            <div>Login as: <span class="text-slate-200 font-medium">Demo User</span></div>
            <div>Role: <span class="text-slate-200 font-medium">Super Admin</span></div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="h-16 flex items-center justify-between px-6 bg-white border-b border-slate-200">
            <div>
                <div class="text-xs uppercase tracking-wide text-slate-500">
                    @yield('page_label', 'Overview')
                </div>
                <h1 class="text-lg font-semibold">
                    @yield('page_title', 'Dashboard')
                </h1>
            </div>

            <div class="text-sm text-slate-500">
                {{ now()->format('d M Y') }}
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>
@stack('scripts')
</body>
</html>

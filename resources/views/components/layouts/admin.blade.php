<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard | Gusii All Stars Foundation' }}</title>

    <!-- Favicon & Touch Icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js for real-time analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 hidden md:flex">
        <!-- Sidebar Brand -->
        <div class="h-20 px-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 text-white flex items-center justify-center font-black relative shadow-lg">
                <span class="font-heading text-xl font-black">G</span>
                <i class="fa-solid fa-star text-[8px] text-amber-300 absolute top-1.5 right-1.5"></i>
            </div>
            <div>
                <span class="font-heading font-extrabold text-lg text-white tracking-wider">GASUA ADMIN</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-grow p-4 space-y-1.5 overflow-y-auto text-xs font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-gauge-high text-base"></i> Dashboard
            </a>
            <a href="{{ route('admin.campaigns') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.campaigns') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-bullhorn text-base"></i> Campaigns
            </a>
            <a href="{{ route('admin.programs') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.programs') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-graduation-cap text-base"></i> Foundation Programs
            </a>
            <a href="{{ route('admin.donations') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.donations') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-hand-holding-dollar text-base"></i> Donations
            </a>
            <a href="{{ route('admin.gateways') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.gateways') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-credit-card text-base"></i> Payment Gateways
            </a>
            <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.logs') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-list-check text-base"></i> Payment & Webhook Logs
            </a>
            <a href="{{ route('admin.volunteers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.volunteers') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-users-viewfinder text-base"></i> Volunteers
            </a>
            <a href="{{ route('admin.events') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.events') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-calendar-days text-base"></i> Events
            </a>
            <a href="{{ route('admin.talents') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.talents') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-star text-base"></i> Talent Showcase
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.reports') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-chart-line text-base"></i> Financial Reports
            </a>
            <a href="{{ route('admin.transparency') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.transparency') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-scale-balanced text-base"></i> Transparency & Audit
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.users') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-user-gear text-base"></i> Users & Roles
            </a>
            <a href="{{ route('admin.cms') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.cms') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-sliders text-base"></i> CMS & Settings
            </a>
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-emerald-400 transition-colors {{ request()->routeIs('admin.profile') ? 'bg-emerald-600 text-white hover:bg-emerald-600 hover:text-white font-bold' : '' }}">
                <i class="fa-solid fa-id-badge text-base"></i> My Profile
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800 text-xs">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-emerald-400 hover:text-emerald-300">
                <i class="fa-solid fa-globe"></i> View Public Website
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-grow flex flex-col min-w-0">

        <!-- Top Navigation Bar -->
        <header class="h-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="font-heading font-bold text-lg md:text-xl text-slate-800 dark:text-slate-100">{{ $headerTitle ?? 'Dashboard' }}</h1>
            </div>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon'"></i>
                </button>

                <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800 group hover:opacity-80 transition-opacity">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs overflow-hidden shadow">
                        @if(auth()->user()?->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()?->name ?? 'SA', 0, 2)) }}
                        @endif
                    </div>
                    <div class="hidden sm:block text-xs">
                        <span class="font-bold block text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 transition-colors">{{ auth()->user()?->name ?? 'Administrator' }}</span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold uppercase">{{ auth()->user()?->roles?->first()?->name ?? 'Super Admin' }}</span>
                    </div>
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 md:p-8 flex-grow overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>

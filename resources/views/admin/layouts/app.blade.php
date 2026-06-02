<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bioskop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $routeName = request()->route()->getName();
    $pageTitle = match (true) {
        $routeName === 'admin.dashboard' => 'Dashboard Admin',
        str_starts_with($routeName, 'admin.films') => 'Manajemen Film',
        str_starts_with($routeName, 'admin.schedules') => 'Manajemen Jadwal',
        str_starts_with($routeName, 'admin.preview') => 'Live Preview User',
        default => 'Admin Bioskop',
    };
@endphp
<body class="min-h-screen bg-[#0f0f13] text-slate-100">
    <div class="min-h-screen lg:flex">
        <aside class="hidden w-72 shrink-0 border-r border-white/5 bg-[#16161d] lg:flex lg:flex-col sticky top-0 h-screen overflow-y-auto">
            <div class="border-b border-white/5 px-6 py-6">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">Admin Panel</p>
                <h1 class="mt-2 text-2xl font-bold text-white">BioskopKu</h1>
                <p class="mt-2 text-sm text-gray-400">Kelola konten bioskop dan buka preview user tanpa masuk ke flow transaksi.</p>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6">
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600/20 text-white border-indigo-400/30' : 'text-slate-300 border-transparent hover:bg-white/5 hover:text-white' }} flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-medium transition">
                    <span>Dashboard</span>
                    <span class="text-xs text-slate-500">Ringkasan</span>
                </a>
                <a href="{{ route('admin.films.index') }}"
                   class="{{ request()->routeIs('admin.films.*') ? 'bg-indigo-600/20 text-white border-indigo-400/30' : 'text-slate-300 border-transparent hover:bg-white/5 hover:text-white' }} flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-medium transition">
                    <span>Film</span>
                </a>
                <a href="{{ route('admin.schedules.index') }}"
                   class="{{ request()->routeIs('admin.schedules.*') ? 'bg-indigo-600/20 text-white border-indigo-400/30' : 'text-slate-300 border-transparent hover:bg-white/5 hover:text-white' }} flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-medium transition">
                    <span>Jadwal Tayang</span>
                </a>
                <a href="{{ route('admin.preview') }}"
                   class="{{ request()->routeIs('admin.preview*') ? 'bg-indigo-600/20 text-white border-indigo-400/30' : 'text-slate-300 border-transparent hover:bg-white/5 hover:text-white' }} flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-medium transition">
                    <span>Live Preview User</span>
                    <span class="text-xs text-slate-500">Preview</span>
                </a>
            </nav>

            <div class="border-t border-white/5 px-4 py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-gray-100 transition hover:bg-white/10">
                        Logout Admin
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="border-b border-white/5 bg-[#0f0f13]/90 backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">Workspace Admin</p>
                        <h2 class="mt-1 text-xl font-bold text-white">{{ $pageTitle }}</h2>
                    </div>

                    <div class="flex items-center gap-3 lg:hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-gray-100 transition hover:bg-white/10">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-indigo-400/20 bg-indigo-500/10 px-4 py-3 text-sm text-indigo-100">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

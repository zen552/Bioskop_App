<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bioskop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 z-40 bg-black/80 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 transform -translate-x-full bg-[#16161d] border-r border-white/5 transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:flex lg:flex-col lg:shrink-0 overflow-y-auto">
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
            <header class="sticky top-0 z-30 border-b border-white/5 bg-[#0f0f13]/90 backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
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
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

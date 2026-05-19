<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bioskop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-indigo-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <span class="font-bold text-lg">🎬 Admin Bioskop</span>
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline text-sm">Dashboard</a>
            <a href="{{ route('admin.films.index') }}" class="hover:underline text-sm">Film</a>
            <a href="{{ route('admin.schedules.index') }}" class="hover:underline text-sm">Jadwal</a>
            <a href="{{ url('/') }}" class="hover:underline text-sm">Web User</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm bg-white text-indigo-700 px-3 py-1 rounded-lg font-semibold hover:bg-indigo-100">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <main class="p-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

</body>
</html>
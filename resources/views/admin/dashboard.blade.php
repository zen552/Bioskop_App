@extends('admin.layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center max-w-md w-full">
        <div class="text-5xl mb-4">🎬</div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Halo Admin!</h1>
        <p class="text-gray-500 mb-8">Selamat datang, {{ Auth::user()->name }}</p>

        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.films.index') }}"
               class="w-full px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition">
                🎞 Atur Film
            </a>
            <a href="{{ url('/') }}"
            class="w-full px-6 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition">
                👥 Web User
            </a>
            <a href="{{ route('admin.schedules.index') }}"
               class="w-full px-6 py-3 bg-amber-500 text-white rounded-xl font-semibold hover:bg-amber-600 transition">
                📅 Atur Jadwal
            </a>
        </div>
    </div>
</div>
@endsection
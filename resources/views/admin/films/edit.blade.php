@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-[2rem] border border-white/5 bg-[#16161d] p-6 shadow-2xl shadow-black/20">
    <h2 class="text-xl font-bold text-white mb-6">Edit Film</h2>

    <form action="{{ route('admin.films.update', $film) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Judul Film</label>
            <input type="text" name="judul" value="{{ old('judul', $film->judul) }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $film->genre) }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Durasi (menit)</label>
            <input type="number" name="durasi" value="{{ old('durasi', $film->durasi) }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('durasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                      class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $film->deskripsi) }}</textarea>
            @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-1">Poster</label>
            @if($film->poster_url)
                <img src="{{ $film->poster_url }}" class="w-20 h-28 object-cover rounded mb-2" alt="{{ $film->judul }}">
            @endif
            <input type="file" name="poster" accept="image/*" class="w-full text-sm text-gray-400">
            @error('poster')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
                Update Film
            </button>
            <a href="{{ route('admin.films.index') }}"
               class="border border-white/10 bg-white/5 text-gray-200 px-6 py-2 rounded-lg hover:bg-white/10 text-sm font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

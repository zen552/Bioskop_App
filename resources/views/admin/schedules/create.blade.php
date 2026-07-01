@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-[2rem] border border-white/5 bg-[#16161d] p-6 shadow-2xl shadow-black/20">
    <h2 class="text-xl font-bold text-white mb-6">Tambah Jadwal Tayang</h2>

    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Film</label>
            <select name="film_id"
                    class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="">-- Pilih Film --</option>
                @foreach($films as $film)
                    <option value="{{ $film->id }}" {{ old('film_id') == $film->id ? 'selected' : '' }}>
                        {{ $film->judul }}
                    </option>
                @endforeach
            </select>
            @error('film_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Studio</label>
            <input type="text" name="studio" value="{{ old('studio') }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Contoh: Studio 1">
            @error('studio')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                   style="color-scheme: dark;"
                   onclick="this.showPicker()"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
            @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Jam Tayang</label>
            <input type="time" name="jam_tayang" value="{{ old('jam_tayang') }}"
                   style="color-scheme: dark;"
                   onclick="this.showPicker()"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
            @error('jam_tayang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-1">Harga (Rp)</label>
            <input type="number" name="harga" value="{{ old('harga') }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Contoh: 50000">
            @error('harga')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
                Simpan Jadwal
            </button>
            <a href="{{ route('admin.schedules.index') }}"
               class="border border-white/10 bg-white/5 text-gray-200 px-6 py-2 rounded-lg hover:bg-white/10 text-sm font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

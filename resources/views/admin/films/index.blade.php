@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Film</h2>
        <a href="{{ route('admin.films.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
            + Tambah Film
        </a>
    </div>

    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Poster</th>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Genre</th>
                <th class="px-4 py-3">Durasi</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($films as $film)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($film->poster)
                        <img src="{{ Storage::url($film->poster) }}"
                             class="w-12 h-16 object-cover rounded">
                    @else
                        <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">
                            No img
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3 font-semibold text-gray-800">{{ $film->judul }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $film->genre }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $film->durasi }} menit</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.films.edit', $film) }}"
                       class="text-indigo-600 hover:underline mr-3 text-xs font-semibold">Edit</a>
                    <form action="{{ route('admin.films.destroy', $film) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Hapus film ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">Belum ada film.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $films->links() }}</div>
</div>
@endsection
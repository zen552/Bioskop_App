@extends('admin.layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/5 bg-[#16161d] p-6 shadow-2xl shadow-black/20">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Manajemen Film</p>
            <h2 class="mt-2 text-2xl font-bold text-white">Daftar film yang tampil di katalog user</h2>
        </div>
        <a href="{{ route('admin.films.create') }}"
           class="inline-flex rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
            Tambah Film
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-white/[0.03] text-xs uppercase tracking-wider text-gray-400">
                    <tr>
                        <th class="px-4 py-4 font-medium">Poster</th>
                        <th class="px-4 py-4 font-medium">Film</th>
                        <th class="px-4 py-4 font-medium">Genre</th>
                        <th class="px-4 py-4 font-medium">Durasi</th>
                        <th class="px-4 py-4 font-medium">Preview</th>
                        <th class="px-4 py-4 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($films as $film)
                        <tr class="bg-[#16161d] transition hover:bg-white/[0.03]">
                            <td class="px-4 py-4">
                                <div class="flex h-20 w-14 items-center justify-center overflow-hidden rounded-xl bg-[#0f0f13]">
                                    @if($film->poster_url)
                                        <img src="{{ $film->poster_url }}" alt="{{ $film->judul }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-[11px] font-semibold uppercase tracking-widest text-gray-500">No art</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-white">{{ $film->judul }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ \Illuminate\Support\Str::limit($film->deskripsi, 60) }}</p>
                            </td>
                            <td class="px-4 py-4 text-gray-300">{{ $film->genre }}</td>
                            <td class="px-4 py-4 text-gray-300">{{ $film->durasi }} menit</td>
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.preview.films.show', $film) }}"
                                   class="text-sm font-semibold text-indigo-300 transition hover:text-indigo-200">
                                    Buka preview
                                </a>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('admin.films.edit', $film) }}"
                                   class="mr-3 text-xs font-semibold text-indigo-300 transition hover:text-indigo-200">
                                    Edit
                                </a>
                                <form action="{{ route('admin.films.destroy', $film) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Hapus film ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs font-semibold text-red-300 transition hover:text-red-200">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400">
                                Belum ada film yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $films->links() }}
    </div>
</div>
@endsection

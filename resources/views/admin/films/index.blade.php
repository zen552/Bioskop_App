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
        <table class="min-w-full text-left text-sm">
                <thead class="bg-white/[0.03] text-xs uppercase tracking-wider text-gray-400">
                    <tr>
                        <th class="px-4 py-4 font-medium">Poster</th>
                        <th class="px-4 py-4 font-medium">Film</th>
                        <th class="hidden px-4 py-4 font-medium md:table-cell">Genre</th>
                        <th class="hidden px-4 py-4 font-medium md:table-cell">Durasi</th>
                        <th class="hidden px-4 py-4 font-medium md:table-cell">Preview</th>
                        <th class="hidden px-4 py-4 text-center font-medium md:table-cell">Aksi</th>
                        <th class="px-4 py-4 text-right font-medium md:hidden">Detail</th>
                    </tr>
                </thead>
                @forelse($films as $film)
                <tbody x-data="{ expanded: false }" class="border-b border-white/5 last:border-0">
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
                            <p class="mt-1 text-xs text-gray-400 whitespace-normal max-w-xs">{{ \Illuminate\Support\Str::limit($film->deskripsi, 60) }}</p>
                        </td>
                        <td class="hidden px-4 py-4 text-gray-300 md:table-cell">{{ $film->genre }}</td>
                        <td class="hidden px-4 py-4 text-gray-300 md:table-cell">{{ $film->durasi }} menit</td>
                        <td class="hidden px-4 py-4 md:table-cell">
                            <a href="{{ route('admin.preview.films.show', $film) }}"
                               class="text-sm font-semibold text-indigo-300 transition hover:text-indigo-200">
                                Buka preview
                            </a>
                        </td>
                        <td class="hidden px-4 py-4 text-center md:table-cell">
                            <a href="{{ route('admin.films.edit', $film) }}"
                               class="mr-3 text-xs font-semibold text-indigo-300 transition hover:text-indigo-200">
                                Edit
                            </a>
                            <form action="{{ route('admin.films.destroy', $film) }}" method="POST" class="inline" onsubmit="return confirm('Hapus film ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-300 transition hover:text-red-200">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-4 text-right md:hidden">
                            <button @click="expanded = !expanded" class="rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white/10">
                                <span x-text="expanded ? 'Tutup' : 'Detail'"></span>
                            </button>
                        </td>
                    </tr>
                    <tr x-show="expanded" class="bg-[#1b1b24] md:hidden" style="display: none;">
                        <td colspan="3" class="px-4 py-4">
                            <div class="flex flex-col gap-3 text-sm">
                                <div><span class="text-gray-400">Genre:</span> <span class="font-semibold text-white">{{ $film->genre }}</span></div>
                                <div><span class="text-gray-400">Durasi:</span> <span class="font-semibold text-white">{{ $film->durasi }} menit</span></div>
                                <div class="mt-2 flex items-center justify-between border-t border-white/10 pt-3">
                                    <a href="{{ route('admin.preview.films.show', $film) }}" class="font-semibold text-indigo-300">Buka preview</a>
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.films.edit', $film) }}" class="font-semibold text-indigo-300">Edit</a>
                                        <form action="{{ route('admin.films.destroy', $film) }}" method="POST" class="inline" onsubmit="return confirm('Hapus film ini?')">
                                            @csrf @method('DELETE')
                                            <button class="font-semibold text-red-300">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                @empty
                <tbody>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-400">
                            Belum ada film yang tersimpan.
                        </td>
                    </tr>
                </tbody>
                @endforelse
            </table>
    </div>

    <div class="mt-4">
        {{ $films->links() }}
    </div>
</div>
@endsection

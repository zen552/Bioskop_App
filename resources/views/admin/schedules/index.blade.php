@extends('admin.layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/5 bg-[#16161d] p-6 shadow-2xl shadow-black/20">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Manajemen Jadwal</p>
            <h2 class="mt-2 text-2xl font-bold text-white">Daftar Jadwal Tayang</h2>
        </div>
        <a href="{{ route('admin.schedules.create') }}"
           class="inline-flex rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
            Tambah Jadwal
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/5">
    <table class="w-full text-sm text-left">
        <thead class="bg-white/[0.03] text-gray-400 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Film</th>
                <th class="hidden px-4 py-3 md:table-cell">Studio</th>
                <th class="hidden px-4 py-3 md:table-cell">Tanggal</th>
                <th class="hidden px-4 py-3 md:table-cell">Jam</th>
                <th class="hidden px-4 py-3 md:table-cell">Harga</th>
                <th class="hidden px-4 py-3 text-center md:table-cell">Aksi</th>
                <th class="px-4 py-3 text-right md:hidden">Detail</th>
            </tr>
        </thead>
        @forelse($schedules as $schedule)
        <tbody x-data="{ expanded: false }" class="border-b border-white/5 last:border-0">
            <tr class="bg-[#16161d] hover:bg-white/[0.03]">
                <td class="px-4 py-3 font-semibold text-white">{{ $schedule->film->judul }}</td>
                <td class="hidden px-4 py-3 text-gray-300 md:table-cell">{{ $schedule->studio }}</td>
                <td class="hidden px-4 py-3 text-gray-300 md:table-cell">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</td>
                <td class="hidden px-4 py-3 text-gray-300 md:table-cell">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</td>
                <td class="hidden px-4 py-3 text-emerald-400 md:table-cell">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</td>
                <td class="hidden px-4 py-3 text-center md:table-cell">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                       class="text-indigo-300 hover:underline mr-3 text-xs font-semibold">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-300 hover:underline text-xs font-semibold">Hapus</button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right md:hidden">
                    <button @click="expanded = !expanded" class="rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white/10">
                        <span x-text="expanded ? 'Tutup' : 'Detail'"></span>
                    </button>
                </td>
            </tr>
            <tr x-show="expanded" class="bg-[#1b1b24] md:hidden" style="display: none;">
                <td colspan="2" class="px-4 py-4 whitespace-normal">
                    <div class="flex flex-col gap-3 text-sm">
                        <div><span class="text-gray-400">Studio:</span> <span class="font-semibold text-white">{{ $schedule->studio }}</span></div>
                        <div><span class="text-gray-400">Tanggal:</span> <span class="font-semibold text-white">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</span></div>
                        <div><span class="text-gray-400">Jam:</span> <span class="font-semibold text-white">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</span></div>
                        <div><span class="text-gray-400">Harga:</span> <span class="font-semibold text-emerald-400">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</span></div>
                        <div class="mt-2 flex items-center justify-end border-t border-white/10 pt-3 gap-4">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="font-semibold text-indigo-300">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button class="font-semibold text-red-300">Hapus</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        @empty
        <tbody>
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-400">Belum ada jadwal.</td>
            </tr>
        </tbody>
        @endforelse
    </table>
    </div>

    <div class="mt-4">{{ $schedules->links() }}</div>
</div>
@endsection

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
                <th class="px-4 py-3">Studio</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Jam</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($schedules as $schedule)
            <tr class="bg-[#16161d] hover:bg-white/[0.03]">
                <td class="px-4 py-3 font-semibold text-white">{{ $schedule->film->judul }}</td>
                <td class="px-4 py-3 text-gray-300">{{ $schedule->studio }}</td>
                <td class="px-4 py-3 text-gray-300">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</td>
                <td class="px-4 py-3 text-gray-300">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</td>
                <td class="px-4 py-3 text-emerald-400">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                       class="text-indigo-300 hover:underline mr-3 text-xs font-semibold">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-300 hover:underline text-xs font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-8 text-gray-400">Belum ada jadwal.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="mt-4">{{ $schedules->links() }}</div>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Jadwal Tayang</h2>
        <a href="{{ route('admin.schedules.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
            + Tambah Jadwal
        </a>
    </div>

    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Film</th>
                <th class="px-4 py-3">Studio</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Jam</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($schedules as $schedule)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-semibold text-gray-800">{{ $schedule->film->judul }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $schedule->studio }}</td>
                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</td>
                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</td>
                <td class="px-4 py-3 text-gray-600">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                       class="text-indigo-600 hover:underline mr-3 text-xs font-semibold">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs font-semibold">Hapus</button>
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

    <div class="mt-4">{{ $schedules->links() }}</div>
</div>
@endsection
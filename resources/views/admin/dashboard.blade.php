@extends('admin.layouts.app')

@section('content')
<section class="rounded-[2rem] border border-white/5 bg-[#16161d] p-8 shadow-2xl shadow-black/20">
    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">Kontrol Utama</p>
    <h1 class="mt-4 max-w-3xl text-3xl font-bold text-white sm:text-4xl">Kelola sisi admin tanpa kehilangan konteks halaman user.</h1>
    <p class="mt-4 max-w-3xl text-sm leading-7 text-gray-300">
        Fokus dashboard ini hanya pada ringkasan konten dan akses cepat ke live preview user.
    </p>

    <div class="mt-8">
        <a href="{{ route('admin.preview') }}"
           class="inline-flex rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
            Buka Live Preview User
        </a>
    </div>
</section>

<section class="mt-6 grid gap-4 md:grid-cols-2">
    <article class="rounded-[1.75rem] border border-white/5 bg-[#16161d] p-6">
        <p class="text-sm text-gray-400">Total film</p>
        <p class="mt-3 text-4xl font-bold text-white">{{ $totalFilms }}</p>
        <p class="mt-2 text-sm text-gray-500">Konten aktif yang tampil di katalog user.</p>
    </article>
    <article class="rounded-[1.75rem] border border-white/5 bg-[#16161d] p-6">
        <p class="text-sm text-gray-400">Jadwal hari ini</p>
        <p class="mt-3 text-4xl font-bold text-white">{{ $todaySchedules }}</p>
        <p class="mt-2 text-sm text-gray-500">Jumlah tayang yang sedang relevan untuk user hari ini.</p>
    </article>
</section>

<section class="mt-6">
    <div class="rounded-[2rem] border border-white/5 bg-[#16161d] p-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Film Terbaru</p>
                <h2 class="mt-2 text-2xl font-bold text-white">Cek poster dan metadata sebelum tayang.</h2>
            </div>
            <a href="{{ route('admin.films.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-gray-200 transition hover:bg-white/5">
                Lihat Semua Film
            </a>
        </div>

        <div class="mt-6 space-y-4">
            @forelse($latestFilms as $film)
                <div class="flex items-center gap-4 rounded-2xl border border-white/5 bg-[#1b1b24] p-4">
                    <div class="flex h-20 w-16 items-center justify-center overflow-hidden rounded-xl bg-[#0f0f13]">
                        @if($film->poster_url)
                            <img src="{{ $film->poster_url }}" alt="{{ $film->judul }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-xs font-semibold uppercase tracking-widest text-gray-500">No art</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-base font-semibold text-white">{{ $film->judul }}</p>
                        <p class="mt-1 text-sm text-indigo-300">{{ $film->genre }}</p>
                        <p class="mt-1 text-sm text-gray-400">{{ $film->durasi }} menit</p>
                    </div>
                    <a href="{{ route('admin.films.edit', $film) }}"
                       class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-gray-200 transition hover:bg-white/5">
                        Edit
                    </a>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 px-6 py-10 text-center text-sm text-gray-400">
                    Belum ada film yang tersimpan.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

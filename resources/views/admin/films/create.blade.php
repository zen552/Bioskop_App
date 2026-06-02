@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-[2rem] border border-white/5 bg-[#16161d] p-6 shadow-2xl shadow-black/20">
    <h2 class="mb-6 text-xl font-bold text-white">Tambah Film</h2>

    <form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Judul Film</label>
            <input type="text" name="judul" value="{{ old('judul') }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Contoh: Avengers Endgame">
            @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4" x-data="multiselectData({
            selected: {{ json_encode(old('genre', [])) }},
            availableGenres: {{ json_encode($genres->pluck('name')->toArray()) }},
            storeRoute: '{{ route('admin.genres.store') }}',
            csrfToken: '{{ csrf_token() }}'
        })">
            <label class="block text-sm font-medium text-gray-300 mb-1">Genre</label>
            <div class="relative">
                <!-- Dropdown Trigger / Selected Tags -->
                <button type="button" @click="open = !open" @click.away="open = false"
                        class="w-full min-h-[42px] rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    
                    <div class="flex flex-wrap gap-1.5 items-center">
                        <template x-if="selected.length === 0">
                            <span class="text-gray-500 text-xs">Pilih Genre...</span>
                        </template>
                        <template x-for="genre in selected" :key="genre">
                            <span class="inline-flex items-center gap-1 bg-indigo-600/30 border border-indigo-400/30 text-indigo-200 text-xs px-2.5 py-1 rounded-lg">
                                <span x-text="genre"></span>
                                <button type="button" @click.stop="removeGenre(genre)" class="hover:text-white text-indigo-400 focus:outline-none">
                                    &times;
                                </button>
                            </span>
                        </template>
                    </div>
                    
                    <svg class="w-4 h-4 text-gray-400 ml-2 shrink-0 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Hidden inputs to submit selection -->
                <template x-for="genre in selected" :key="'input-' + genre">
                    <input type="hidden" name="genre[]" :value="genre">
                </template>

                <!-- Dropdown Panel -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute z-50 mt-2 w-full rounded-2xl border border-white/10 bg-[#16161d] shadow-2xl p-4" 
                     style="display: none;">
                    
                    <!-- Search inside dropdown -->
                    <div class="mb-3">
                        <input type="text" x-model="search" placeholder="Cari genre..."
                               class="w-full rounded-lg border border-white/5 bg-[#0f0f13] px-3 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <!-- Genre list -->
                    <div class="max-h-48 overflow-y-auto space-y-1.5 pr-1 scrollbar-thin scrollbar-thumb-white/10">
                        <template x-for="genre in filteredGenres" :key="genre">
                            <label class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-white/5 cursor-pointer text-sm text-gray-300 transition-colors">
                                <input type="checkbox" :value="genre" :checked="selected.includes(genre)" @change="toggleGenre(genre)"
                                       class="rounded border-white/10 bg-[#0f0f13] text-indigo-600 focus:ring-indigo-500">
                                <span x-text="genre"></span>
                            </label>
                        </template>
                        <template x-if="filteredGenres.length === 0 && search.trim() !== ''">
                            <p class="text-xs text-gray-400 p-2 italic">Genre tidak ditemukan.</p>
                        </template>
                    </div>

                    <!-- Add new genre -->
                    <div class="mt-3 pt-3 border-t border-white/5">
                        <div class="flex gap-2">
                            <input type="text" x-model="newGenreName" placeholder="Tambah genre baru..." @keydown.enter.prevent="addGenre()"
                                   class="flex-1 rounded-lg border border-white/5 bg-[#0f0f13] px-3 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <button type="button" @click="addGenre()"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition-colors">
                                Tambah
                            </button>
                        </div>
                        <p x-show="errorMessage" x-text="errorMessage" class="text-red-500 text-[10px] mt-1.5" style="display: none;"></p>
                    </div>
                </div>
            </div>
            @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Durasi (menit)</label>
            <input type="number" name="durasi" value="{{ old('durasi') }}"
                   class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Contoh: 120">
            @error('durasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                      class="w-full rounded-xl border border-white/10 bg-[#0f0f13] px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                      placeholder="Sinopsis film...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-1">Poster (opsional)</label>
            <input type="file" name="poster" accept="image/*"
                   class="w-full text-sm text-gray-400">
            @error('poster')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
                Simpan Film
            </button>
            <a href="{{ route('admin.films.index') }}"
                class="border border-white/10 bg-white/5 text-gray-200 px-6 py-2 rounded-lg hover:bg-white/10 text-sm font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function multiselectData(config) {
        return {
            open: false,
            selected: config.selected || [],
            availableGenres: config.availableGenres || [],
            search: '',
            newGenreName: '',
            errorMessage: '',
            storeRoute: config.storeRoute,
            csrfToken: config.csrfToken,

            get filteredGenres() {
                if (this.search.trim() === '') {
                    return this.availableGenres;
                }
                return this.availableGenres.filter(g => 
                    g.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            toggleGenre(genre) {
                if (this.selected.includes(genre)) {
                    this.selected = this.selected.filter(g => g !== genre);
                } else {
                    this.selected.push(genre);
                }
            },

            removeGenre(genre) {
                this.selected = this.selected.filter(g => g !== genre);
            },

            async addGenre() {
                const name = this.newGenreName.trim();
                if (!name) return;

                // Cek apakah sudah ada di availableGenres secara lokal
                const existsLocally = this.availableGenres.some(
                    g => g.toLowerCase() === name.toLowerCase()
                );

                if (existsLocally) {
                    const matchingGenre = this.availableGenres.find(
                        g => g.toLowerCase() === name.toLowerCase()
                    );
                    if (!this.selected.includes(matchingGenre)) {
                        this.selected.push(matchingGenre);
                    }
                    this.newGenreName = '';
                    this.errorMessage = '';
                    return;
                }

                try {
                    this.errorMessage = '';
                    const response = await fetch(this.storeRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name: name })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        const newGenre = data.genre.name;
                        this.availableGenres.push(newGenre);
                        this.availableGenres.sort();
                        this.selected.push(newGenre);
                        this.newGenreName = '';
                    } else {
                        this.errorMessage = data.message || 'Gagal menambahkan genre.';
                    }
                } catch (error) {
                    this.errorMessage = 'Terjadi kesalahan sistem.';
                    console.error(error);
                }
            }
        };
    }
</script>
@endpush

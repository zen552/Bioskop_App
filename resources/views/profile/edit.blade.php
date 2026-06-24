<x-guest-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Profile</h1>
            <p class="mt-2 text-sm text-gray-400">
                Kelola informasi akun dan password Anda.
            </p>
        </div>
        <a href="{{ route('home') }}" class="text-sm px-4 py-2 bg-white/5 hover:bg-white/10 rounded-xl transition text-white border border-white/10">
            ← Kembali
        </a>
    </div>

    <div class="space-y-6">
        <div class="p-4 sm:p-6 bg-white/5 border border-white/5 shadow sm:rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-6 bg-white/5 border border-white/5 shadow sm:rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-6 bg-white/5 border border-white/5 shadow sm:rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-guest-layout>

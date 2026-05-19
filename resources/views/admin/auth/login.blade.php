<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Login Admin</h1>
        <p class="mt-2 text-sm text-gray-600">Halaman ini khusus admin. User masuk dari login publik.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-between gap-3">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 underline hover:text-gray-900">
                Login user
            </a>

            <x-primary-button>
                Masuk Admin
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

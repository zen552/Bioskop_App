<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-white">Lupa Password</h1>
        <p class="mt-2 text-sm text-gray-400 leading-relaxed">
            Masukkan alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi baru.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-indigo-400 hover:text-indigo-300 transition" href="{{ route('login') }}">
                Kembali ke Login
            </a>
            
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

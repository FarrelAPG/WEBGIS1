<x-guest-layout>
    <!-- Header SIGAP DAMKAR -->
    <div class="mb-5 text-center">
        <h2 class="text-xl font-black tracking-tight text-slate-900">Portal Petugas Damkar</h2>
        <p class="text-xs text-slate-500 mt-1">Masuk untuk mengakses Dashboard Operasional Damkar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember" checked>
                <span class="ms-2 text-xs text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-5">
            <a class="text-xs text-slate-500 hover:text-slate-800" href="{{ url('/') }}">
                ← Kembali ke Portal
            </a>

            <x-primary-button class="bg-[#bd101b] hover:bg-[#a00e17] focus:bg-[#a00e17] active:bg-[#850b13]">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

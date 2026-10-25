<x-guest-layout>
    <!-- Header SIGAP DAMKAR -->
    <div class="mb-5 text-center">
        <h2 class="text-xl font-black tracking-tight text-slate-900">Portal Petugas Damkar</h2>
        <p class="text-xs text-slate-500 mt-1">Masuk untuk mengakses Dashboard Operasional Damkar</p>
    </div>

    <!-- Kotak Demo / Quick Login -->
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50/80 p-3.5 text-xs text-slate-700">
        <div class="flex items-center justify-between gap-2">
            <span class="inline-flex items-center gap-1 font-bold text-red-700">
                <span class="h-2 w-2 rounded-full bg-red-600 animate-pulse"></span>
                Akun Demo Petugas:
            </span>
            <button type="button" onclick="isiAkunDemo()" class="font-extrabold text-[#bd101b] hover:underline">
                Isi ke Form ✍️
            </button>
        </div>
        <div class="mt-2 space-y-0.5 font-mono text-[11px] text-slate-600">
            <div>Email: <strong class="text-slate-900">damkar@sigap.test</strong></div>
            <div>Password: <strong class="text-slate-900">password</strong></div>
        </div>
        <div class="mt-3">
            <a href="{{ route('login.damkar.demo') }}" class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#bd101b] px-3 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#a00e17]">
                <span>⚡ 1-Klik Masuk sebagai Petugas Damkar</span>
            </a>
        </div>
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

    <script>
        function isiAkunDemo() {
            document.getElementById('email').value = 'damkar@sigap.test';
            document.getElementById('password').value = 'password';
        }
    </script>
</x-guest-layout>

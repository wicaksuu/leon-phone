<x-guest-layout>
    <!-- Judul Halaman -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Masuk ke Akun Anda
        </h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold mb-2 dark:text-white">Alamat Email</label>
            <x-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@perusahaan.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-semibold dark:text-white">Kata Sandi (Password)</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 font-medium" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <x-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-neutral-400">Ingat sesi masuk saya</label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-button variant="primary" type="submit" class="w-full py-3">
                <iconify-icon icon="solar:login-linear" class="text-lg"></iconify-icon>
                Masuk Sistem
            </x-button>
        </div>
    </form>
</x-guest-layout>

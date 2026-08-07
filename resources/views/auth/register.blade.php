<x-guest-layout>
    <!-- Judul Halaman -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Daftar Akun Baru
        </h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold mb-2 dark:text-white">Nama Lengkap</label>
            <x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold mb-2 dark:text-white">Alamat Email</label>
            <x-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@perusahaan.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold mb-2 dark:text-white">Kata Sandi (Password)</label>
            <x-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan kata sandi baru" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2 dark:text-white">Konfirmasi Kata Sandi</label>
            <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 font-medium" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-button variant="primary" type="submit" class="py-2.5 px-4">
                <iconify-icon icon="solar:user-plus-linear" class="text-lg"></iconify-icon>
                Daftar Akun
            </x-button>
        </div>
    </form>
</x-guest-layout>

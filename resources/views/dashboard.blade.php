<x-app-layout>
    <!-- Welcome Widget -->
    <div class="relative flex items-center justify-between bg-blue-50 dark:bg-blue-900/30 rounded-xl p-6 mb-6 border border-blue-100 dark:border-blue-800/50">
        <div class="flex items-center gap-3">
            <div class="relative shrink-0">
                <img class="inline-block h-12 w-12 rounded-full ring-2 ring-blue-100 dark:ring-blue-900/50" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
            </div>
            <div class="flex flex-col gap-0.5">
                <h5 class="text-lg font-bold text-gray-800 dark:text-white">Selamat Datang Kembali, Administrator! 👋</h5>
                <p class="text-sm text-gray-500 dark:text-neutral-400">Database PT: Leon Sellular Indonesia • Sesi Aktif</p>
            </div>
        </div>
        
        <!-- Action Button Toast demo -->
        <div class="flex items-center gap-2">
            <x-button variant="outline" class="hidden sm:inline-flex" data-hs-overlay="#test-modal-dialog">
                <iconify-icon icon="solar:info-square-linear" class="text-lg"></iconify-icon>
                Info Sistem
            </x-button>
            <x-button variant="primary">
                <iconify-icon icon="solar:refresh-linear" class="text-lg"></iconify-icon>
                Segarkan Data
            </x-button>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <x-card title="Pegawai" subtitle="Total Staff Terdaftar">
            <div class="flex justify-between items-center">
                <span class="text-3xl font-extrabold text-blue-600 dark:text-blue-500">96</span>
                <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-4xl text-blue-500/20"></iconify-icon>
            </div>
        </x-card>
        <x-card title="Pelanggan" subtitle="Klien Retail & Grosir">
            <div class="flex justify-between items-center">
                <span class="text-3xl font-extrabold text-yellow-600 dark:text-yellow-500">3,650</span>
                <iconify-icon icon="solar:user-speak-linear" class="text-4xl text-yellow-500/20"></iconify-icon>
            </div>
        </x-card>
        <x-card title="Aset Tetap" subtitle="Inventaris Elektronik PT">
            <div class="flex justify-between items-center">
                <span class="text-3xl font-extrabold text-green-600 dark:text-green-500">356</span>
                <iconify-icon icon="solar:box-linear" class="text-4xl text-green-500/20"></iconify-icon>
            </div>
        </x-card>
        <x-card title="Pesanan Pending" subtitle="Faktur Belum Terbayar">
            <div class="flex justify-between items-center">
                <span class="text-3xl font-extrabold text-red-600 dark:text-red-500">12</span>
                <iconify-icon icon="solar:danger-linear" class="text-4xl text-red-500/20"></iconify-icon>
            </div>
        </x-card>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Table Card -->
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Riwayat Aktivitas & Transaksi" subtitle="Data real-time 5 transaksi terakhir">
                <x-table>
                    <thead class="bg-gray-50 dark:bg-neutral-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Kode Faktur</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Nama Customer</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Total Transaksi</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 dark:text-blue-500">SI-2026-0001</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Budi Santoso</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Rp 12.500.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <x-badge variant="success">LUNAS</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 dark:text-blue-500">SI-2026-0002</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Leon Sellular Shop</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Rp 45.000.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <x-badge variant="success">LUNAS</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 dark:text-blue-500">SI-2026-0003</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Siti Rahma</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Rp 8.900.000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <x-badge variant="warning">BELUM BAYAR</x-badge>
                            </td>
                        </tr>
                    </tbody>
                </x-table>
            </x-card>
        </div>

        <!-- Inputs and Tooltips Info Card -->
        <div class="space-y-6">
            <x-card title="Pengujian Input Kustom" subtitle="Form input semantik dengan style Preline">
                <div class="space-y-4">
                    <div>
                        <label for="sample_code" class="block text-sm font-semibold mb-2 dark:text-white">Kode Scanner (Barcode/IMEI)</label>
                        <x-input id="sample_code" type="text" placeholder="Scan Barcode IMEI..." />
                    </div>
                    <div>
                        <label for="sample_qty" class="block text-sm font-semibold mb-2 dark:text-white">Jumlah (Quantity)</label>
                        <x-input id="sample_qty" type="number" placeholder="10" />
                    </div>
                    <div class="pt-2 flex gap-2">
                        <x-button variant="danger" class="flex-1">Batal</x-button>
                        <x-button variant="success" class="flex-1">Simpan Data</x-button>
                    </div>
                </div>
            </x-card>

            <!-- Small Toast Notification Component Demo -->
            <x-toast variant="success" message="Semua komponen Blade visual berhasil termuat secara penuh!" />
        </div>
    </div>

    <!-- Info Modal Dialog -->
    <x-modal id="test-modal-dialog" title="Informasi Sistem Leon Phone RMS">
        <div class="space-y-3">
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Sistem **LEON PHONE RMS** dikonfigurasi menggunakan arsitektur modular domain.
            </p>
            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg dark:bg-neutral-900 dark:border-neutral-800">
                <span class="block text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase">Dukungan Framework</span>
                <span class="block text-sm font-semibold text-gray-800 dark:text-white">Laravel 13.x + Tailwind CSS 4 + Preline UI 3.0</span>
            </div>
            <div class="flex justify-end gap-x-2 pt-4">
                <x-button variant="secondary" data-hs-overlay="#test-modal-dialog">Tutup</x-button>
                <x-button variant="primary" data-hs-overlay="#test-modal-dialog">Oke</x-button>
            </div>
        </div>
    </x-modal>
</x-app-layout>

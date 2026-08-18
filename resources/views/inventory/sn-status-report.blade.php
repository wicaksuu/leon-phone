<x-app-layout>
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700 rounded-xl p-6 mb-6 shadow-sm">
        <div>
            <h1 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <iconify-icon icon="solar:box-linear" class="text-blue-600 dark:text-blue-500 text-xl"></iconify-icon>
                <span>Laporan Status S/N & IMEI</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Melacak status kepemilikan, lokasi gudang, dan riwayat transaksi Serial Number / IMEI</p>
        </div>
    </div>

    <!-- Search Form Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 p-6 mb-6">
        <form class="space-y-4">
            <div class="max-w-xl">
                <label for="sn_search" class="block text-sm font-semibold mb-2 dark:text-white">Masukkan Serial Number / IMEI</label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" id="sn_search" value="880912345" placeholder="Contoh: 880912345..." class="py-2.5 ps-10 pe-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <iconify-icon icon="solar:barcode-linear" class="text-gray-400 dark:text-neutral-500 text-lg"></iconify-icon>
                        </div>
                    </div>
                    <x-button variant="primary" class="px-6 flex items-center gap-2">
                        <iconify-icon icon="solar:magnifier-linear" class="text-lg"></iconify-icon>
                        <span>Cari S/N</span>
                    </x-button>
                </div>
            </div>
        </form>
    </div>

    <!-- Trace Result Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
                Hasil Pelacakan S/N: <span class="font-mono text-blue-600 dark:text-blue-500">880912345</span>
            </h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Status -->
                <div class="space-y-3">
                    <span class="block text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase">STATUS SAAT INI</span>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg dark:bg-neutral-900/60 dark:border-neutral-800">
                        <x-badge variant="success" class="mb-2">DALAM GUDANG</x-badge>
                        <span class="block text-sm font-bold text-gray-800 dark:text-white">Gudang PT LEON</span>
                        <span class="block text-xs text-gray-500 dark:text-neutral-400 mt-1">Kondisi: Baik / Baru</span>
                    </div>
                </div>

                <!-- Info Produk -->
                <div class="space-y-3">
                    <span class="block text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase">INFORMASI PRODUK</span>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg dark:bg-neutral-900/60 dark:border-neutral-800">
                        <span class="block text-sm font-bold text-gray-800 dark:text-white">REALME 10 PRO+ 5G</span>
                        <span class="block text-xs text-gray-500 dark:text-neutral-400 mt-1">Brand: Realme • Kategori: Handphone</span>
                    </div>
                </div>

                <!-- Info Masuk -->
                <div class="space-y-3">
                    <span class="block text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase">RIWAYAT MASUK</span>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg dark:bg-neutral-900/60 dark:border-neutral-800">
                        <span class="block text-sm font-semibold text-gray-800 dark:text-white">Faktur PI-2026/08-0113</span>
                        <span class="block text-xs text-gray-500 dark:text-neutral-400 mt-1">Tanggal: 07-08-2026 • Supplier: Blibli</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

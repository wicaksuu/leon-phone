<x-app-layout>
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700 rounded-xl p-6 mb-6 shadow-sm">
        <div>
            <h1 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <iconify-icon icon="solar:box-linear" class="text-blue-600 dark:text-blue-500 text-xl"></iconify-icon>
                <span>Cetak Barcode Label</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Konfigurasi template cetak barcode produk untuk label harga / kardus HP</p>
        </div>
    </div>

    <!-- Form Configuration Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 p-6">
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label for="template" class="block text-sm font-semibold mb-2 dark:text-white">Template Label</label>
                        <select id="template" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option>Template Standard Roxy (3 Kolom)</option>
                            <option>Template Eceran (1 Kolom)</option>
                            <option>Template Label IMEI (2 Kolom)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="paper_width" class="block text-sm font-semibold mb-2 dark:text-white">Lebar Kertas (inch)</label>
                            <x-input id="paper_width" type="text" value="3.15" />
                        </div>
                        <div>
                            <label for="paper_height" class="block text-sm font-semibold mb-2 dark:text-white">Tinggi Kertas (inch)</label>
                            <x-input id="paper_height" type="text" value="1.18" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="label_width" class="block text-sm font-semibold mb-2 dark:text-white">Lebar Label (inch)</label>
                            <x-input id="label_width" type="text" value="1.00" />
                        </div>
                        <div>
                            <label for="label_height" class="block text-sm font-semibold mb-2 dark:text-white">Tinggi Label (inch)</label>
                            <x-input id="label_height" type="text" value="0.90" />
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label for="default_printer" class="block text-sm font-semibold mb-2 dark:text-white">Default Printer</label>
                        <x-input id="default_printer" type="text" value="Zebra ZD220 GP USB" />
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="padding_top" class="block text-sm font-semibold mb-2 dark:text-white">Padding Top (px)</label>
                            <x-input id="padding_top" type="number" value="5" />
                        </div>
                        <div>
                            <label for="baris1" class="block text-sm font-semibold mb-2 dark:text-white">Baris 1 (px)</label>
                            <x-input id="baris1" type="number" value="12" />
                        </div>
                        <div>
                            <label for="baris2" class="block text-sm font-semibold mb-2 dark:text-white">Baris 2 (px)</label>
                            <x-input id="baris2" type="number" value="12" />
                        </div>
                    </div>
                    <div>
                        <label for="barcode_type" class="block text-sm font-semibold mb-2 dark:text-white">Format Kode</label>
                        <select id="barcode_type" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option>CODE-128 (Standard)</option>
                            <option>EAN-13</option>
                            <option>QR-Code</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-gray-200 dark:border-neutral-700 flex justify-end gap-2">
                <x-button variant="outline">Reset Template</x-button>
                <x-button variant="primary" class="flex items-center gap-2">
                    <iconify-icon icon="solar:printer-minimalistic-linear" class="text-lg"></iconify-icon>
                    <span>Simpan & Cetak Test</span>
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>

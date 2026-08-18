<x-app-layout>
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700 rounded-xl p-6 mb-6 shadow-sm">
        <div>
            <h1 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <iconify-icon icon="solar:box-linear" class="text-blue-600 dark:text-blue-500 text-xl"></iconify-icon>
                <span>Master Ukuran (Sizes)</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Mengelola dimensi dan ukuran fisik barang dalam sistem</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <x-button variant="primary" class="flex items-center gap-2">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                <span>Tambah Ukuran</span>
            </x-button>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Top Toolbar -->
        <div class="p-5 border-b border-gray-200 dark:border-neutral-700 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Search -->
            <div class="relative w-full md:w-72">
                <input type="text" placeholder="Cari ukuran..." class="py-2 ps-10 pe-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                    <iconify-icon icon="solar:magnifier-linear" class="text-gray-400 dark:text-neutral-500"></iconify-icon>
                </div>
            </div>
            <!-- Filter Actions -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                <x-button variant="outline" class="flex items-center gap-2">
                    <iconify-icon icon="solar:filter-linear" class="text-lg"></iconify-icon>
                    <span>Filter</span>
                </x-button>
            </div>
        </div>

        <!-- Table Listing -->
        <x-table>
            <thead class="bg-gray-50 dark:bg-neutral-700/40">
                <tr>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Kode</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Nama Ukuran</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Status</th>
                    <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-white">6.1 INCH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-300">Dimensi Layar Standard (iPhone 15 / 15 Pro)</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <x-badge variant="success">Aktif</x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex items-center justify-end gap-2">
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-500"><iconify-icon icon="solar:pen-linear" class="text-lg"></iconify-icon></button>
                        <button class="text-red-600 hover:text-red-900 dark:text-red-500"><iconify-icon icon="solar:trash-bin-trash-linear" class="text-lg"></iconify-icon></button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-white">6.7 INCH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-300">Dimensi Layar Besar (Plus / Pro Max)</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <x-badge variant="success">Aktif</x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex items-center justify-end gap-2">
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-500"><iconify-icon icon="solar:pen-linear" class="text-lg"></iconify-icon></button>
                        <button class="text-red-600 hover:text-red-900 dark:text-red-500"><iconify-icon icon="solar:trash-bin-trash-linear" class="text-lg"></iconify-icon></button>
                    </td>
                </tr>
            </tbody>
        </x-table>
    </div>
</x-app-layout>

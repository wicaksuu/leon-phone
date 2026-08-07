<div class="px-6 flex items-center justify-between">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-blue-600 dark:text-blue-500">
        <iconify-icon icon="solar:phone-calling-bold" class="text-2xl"></iconify-icon>
        <span>LEON PHONE</span>
    </a>
</div>

<nav class="hs-accordion-group w-full flex flex-col px-3 mt-6">
    <ul class="space-y-1.5">
        <!-- Dashboard -->
        <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-500' : 'text-gray-700 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300' }} text-sm font-medium rounded-lg" href="{{ route('dashboard') }}">
                <iconify-icon icon="solar:widget-linear" class="text-xl"></iconify-icon>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Persediaan -->
        <li class="hs-accordion" id="inventory-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:box-linear" class="text-xl"></iconify-icon>
                <span>Persediaan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="inventory-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Master Barang
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Gudang & Cabang
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Stok Opname
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Transfer Gudang
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Pembelian -->
        <li class="hs-accordion" id="purchase-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:bag-3-linear" class="text-xl"></iconify-icon>
                <span>Pembelian</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="purchase-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Purchase Request (PR)
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Purchase Order (PO)
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Faktur Pembelian (PI)
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Penjualan -->
        <li class="hs-accordion" id="sales-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:bill-list-linear" class="text-xl"></iconify-icon>
                <span>Penjualan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="sales-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Sales Order (SO)
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Delivery Order (DO)
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Faktur Penjualan (SI)
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Keuangan -->
        <li class="hs-accordion" id="finance-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:card-transfer-linear" class="text-xl"></iconify-icon>
                <span>Keuangan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="finance-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Penerimaan Kas/Bank
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Pembayaran Kas/Bank
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Cek / Giro
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Akunting -->
        <li class="hs-accordion" id="accounting-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:calculator-linear" class="text-xl"></iconify-icon>
                <span>Akunting</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="accounting-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Daftar Akun (COA)
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Jurnal Manual
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Aset Tetap
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <hr class="my-3 border-gray-200 dark:border-neutral-700">

        <!-- Leon Phone Tambahan -->
        <div class="px-2.5 mb-2">
            <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-neutral-500">Operasional & Toko</span>
        </div>

        <!-- POS Kasir -->
        <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" href="#">
                <iconify-icon icon="solar:shop-linear" class="text-xl"></iconify-icon>
                <span>POS Kasir</span>
            </a>
        </li>

        <!-- Packing Station -->
        <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" href="#">
                <iconify-icon icon="solar:box-minimalistic-linear" class="text-xl"></iconify-icon>
                <span>Packing Station</span>
            </a>
        </li>

        <!-- Marketplace -->
        <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" href="#">
                <iconify-icon icon="solar:global-linear" class="text-xl"></iconify-icon>
                <span>Marketplace Engine</span>
            </a>
        </li>

        <!-- Servis & Garansi -->
        <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" href="#">
                <iconify-icon icon="solar:settings-linear" class="text-xl"></iconify-icon>
                <span>Servis & Garansi</span>
            </a>
        </li>

        <hr class="my-3 border-gray-200 dark:border-neutral-700">

        <!-- Utiliti / Setting -->
        <li class="hs-accordion" id="utility-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:tuning-square-2-linear" class="text-xl"></iconify-icon>
                <span>Utiliti</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="utility-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Setting Cabang
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Setting Password
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            Maintenance Data
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>

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

        <!-- Persediaan (Inventory) -->
        <li class="hs-accordion" id="inventory-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="inventory-accordion-child">
                <iconify-icon icon="solar:box-linear" class="text-xl"></iconify-icon>
                <span>Persediaan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="inventory-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="inventory-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.units') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.units') }}">Master Satuan</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.sizes') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.sizes') }}">Master Ukuran</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.goods-groups') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.goods-groups') }}">Kelompok Barang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.brands') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.brands') }}">Master Brand</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.goods') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 font-semibold' }}" href="{{ route('inventory.goods') }}">Master Barang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.sales-price-groups') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.sales-price-groups') }}">Kelompok Harga Jual</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.warehouses') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.warehouses') }}">Master Gudang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.print-barcode') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.print-barcode') }}">Cetak Barcode</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.stock-opnames') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.stock-opnames') }}">Stok Opname</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.transfers-temp') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.transfers-temp') }}">Transfer Sementara</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.transfers-wh') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.transfers-wh') }}">Transfer Gudang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.adjust-stocks') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.adjust-stocks') }}">Penyesuaian Stok</a></li>
                    
                    <!-- Perakitan (Nested Sub-menu) -->
                    <li class="hs-accordion" id="assembly-accordion">
                        <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" aria-controls="assembly-accordion-child">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            <span>Perakitan</span>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs ms-auto hs-accordion-active:hidden"></iconify-icon>
                            <iconify-icon icon="solar:alt-arrow-up-linear" class="text-xs ms-auto hs-accordion-active:block hidden"></iconify-icon>
                        </button>
                        <div id="assembly-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                            <ul class="ps-6 space-y-1 pt-1">
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs {{ request()->routeIs('inventory.assembly.raw-materials') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.assembly.raw-materials') }}">Pemakaian Bahan Baku</a></li>
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs {{ request()->routeIs('inventory.assembly.fin-materials') ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.assembly.fin-materials') }}">Penyelesaian Barang Jadi</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm {{ request()->routeIs('inventory.sn-status') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300' }}" href="{{ route('inventory.sn-status') }}">Laporan Status S/N</a></li>
                </ul>
            </div>
        </li>

        <!-- Pembelian (Purchasing) -->
        <li class="hs-accordion" id="purchase-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="purchase-accordion-child">
                <iconify-icon icon="solar:bag-3-linear" class="text-xl"></iconify-icon>
                <span>Pembelian</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="purchase-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="purchase-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Kelompok Supplier</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Supplier</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Surat Permintaan / PR</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tutup SPB</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Order Pembelian / PO</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 font-semibold text-blue-600" href="#">Faktur Pembelian / PI</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Retur Pembelian</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Nota Penerimaan / RO</a></li>
                </ul>
            </div>
        </li>

        <!-- Penjualan (Sales) -->
        <li class="hs-accordion" id="sales-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="sales-accordion-child">
                <iconify-icon icon="solar:bill-list-linear" class="text-xl"></iconify-icon>
                <span>Penjualan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="sales-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="sales-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Kelompok Pelanggan</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Salesman</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Pelanggan</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tabel Poin</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Promo</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Penawaran / SQ</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Order Penjualan / SO</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tutup SO</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Nota Pengiriman / DO</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 font-semibold text-blue-600" href="#">Faktur Penjualan / SI</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Retur Penjualan</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 font-bold text-red-500" href="#">Point Of Sale (POS)</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">E-Faktur</a></li>
                </ul>
            </div>
        </li>

        <!-- Keuangan (Finance) -->
        <li class="hs-accordion" id="finance-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="finance-accordion-child">
                <iconify-icon icon="solar:card-transfer-linear" class="text-xl"></iconify-icon>
                <span>Keuangan</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="finance-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="finance-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tipe Bayar</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Bank</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Transaksi Bank</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Cek & Giro</a></li>
                    
                    <!-- Hutang Dagang (Nested Sub-menu) -->
                    <li class="hs-accordion" id="ap-accordion">
                        <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" aria-controls="ap-accordion-child">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            <span>Hutang Dagang</span>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs ms-auto hs-accordion-active:hidden"></iconify-icon>
                            <iconify-icon icon="solar:alt-arrow-up-linear" class="text-xs ms-auto hs-accordion-active:block hidden"></iconify-icon>
                        </button>
                        <div id="ap-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                            <ul class="ps-6 space-y-1 pt-1">
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tanda Terima</a></li>
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Uang Muka</a></li>
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Pembayaran</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Piutang Dagang (Nested Sub-menu) -->
                    <li class="hs-accordion" id="ar-accordion">
                        <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" aria-controls="ar-accordion-child">
                            <iconify-icon icon="tabler:circle" class="text-[6px]"></iconify-icon>
                            <span>Piutang Dagang</span>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs ms-auto hs-accordion-active:hidden"></iconify-icon>
                            <iconify-icon icon="solar:alt-arrow-up-linear" class="text-xs ms-auto hs-accordion-active:block hidden"></iconify-icon>
                        </button>
                        <div id="ar-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                            <ul class="ps-6 space-y-1 pt-1">
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Nota Tagihan</a></li>
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Uang Muka</a></li>
                                <li><a class="flex items-center gap-x-2 py-1 px-2 text-xs text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Penerimaan</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Akunting (Accounting) -->
        <li class="hs-accordion" id="accounting-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="accounting-accordion-child">
                <iconify-icon icon="solar:calculator-linear" class="text-xl"></iconify-icon>
                <span>Akunting</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="accounting-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="accounting-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Daftar Akun (COA)</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Cost Centre</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Setting Akun Analisis</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Kas Bank (Masuk/Keluar)</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Jurnal Umum</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Jurnal Trading / GL</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Aktiva Tetap (Fixed Assets)</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Recurring</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Jurnal Posting</a></li>
                </ul>
            </div>
        </li>

        <!-- Saldo Awal -->
        <li class="hs-accordion" id="initial-balance-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="initial-balance-accordion-child">
                <iconify-icon icon="solar:folder-with-files-linear" class="text-xl"></iconify-icon>
                <span>Saldo Awal</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="initial-balance-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="initial-balance-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Persediaan Barang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Hutang Dagang Awal</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Piutang Dagang Awal</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Neraca Awal</a></li>
                </ul>
            </div>
        </li>

        <hr class="my-3 border-gray-200 dark:border-neutral-700">

        <div class="px-2.5 mb-2">
            <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-neutral-500">Sistem & Diagnostik</span>
        </div>

        <!-- Utiliti -->
        <li class="hs-accordion" id="utility-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="utility-accordion-child">
                <iconify-icon icon="solar:tuning-square-2-linear" class="text-xl"></iconify-icon>
                <span>Utiliti</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="utility-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="utility-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Setting Cabang</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Setting Password/User</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Setting Menu User</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Ganti/Tutup Periode</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Tutup Buku</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Buka Kunci Data</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Validasi Data</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Maintenance Data</a></li>
                </ul>
            </div>
        </li>

        <!-- Help / Tools -->
        <li class="hs-accordion" id="help-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300" aria-controls="help-accordion-child">
                <iconify-icon icon="solar:shield-warning-linear" class="text-xl"></iconify-icon>
                <span>Help / Tools</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-sm ms-auto hs-accordion-active:hidden"></iconify-icon>
                <iconify-icon icon="solar:alt-arrow-up-linear" class="text-sm ms-auto hs-accordion-active:block hidden"></iconify-icon>
            </button>
            <div id="help-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" aria-labelledby="help-accordion">
                <ul class="pt-1.5 ps-4 space-y-1">
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Kroscek IMEI</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Minus Stock</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Jurnal Check</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Kroscek Error</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Update Stok Formula</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Laporan Hapus Data</a></li>
                    <li><a class="flex items-center gap-x-2 py-1.5 px-2 text-sm text-gray-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300" href="#">Laporan Log</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>

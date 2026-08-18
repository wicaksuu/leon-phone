<x-app-layout>
    <!-- Welcome Header & Running Clock -->
    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between bg-blue-50/50 dark:bg-neutral-900/40 border border-blue-100/60 dark:border-neutral-800 rounded-xl p-6 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <iconify-icon icon="solar:widget-bold" class="text-blue-600 dark:text-blue-500 text-2xl"></iconify-icon>
                <span>Dashboard Utama</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Sesi Aktif Perusahaan • Real-time Monitoring & Analytics</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-3 bg-white dark:bg-neutral-800/80 px-4 py-2 rounded-lg border border-gray-100 dark:border-neutral-700/60 shadow-sm">
            <iconify-icon icon="solar:calendar-date-linear" class="text-blue-600 dark:text-blue-500 text-lg"></iconify-icon>
            <div class="text-xs text-gray-700 dark:text-neutral-300 font-semibold" id="running-clock-display">
                Memuat Waktu...
            </div>
        </div>
    </div>

    <!-- Row 1: Info Data Perusahaan & Aktivitas Terakhir -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Info Data Perusahaan -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:info-circle-linear" class="text-blue-600 dark:text-blue-500 text-lg"></iconify-icon>
                    <span>Info Data Perusahaan</span>
                </h3>
                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500">
                    <span class="w-1.5 h-1.5 inline-block rounded-full bg-green-600 dark:bg-green-500"></span>
                    Online
                </span>
            </div>
            <div class="p-5 flex-1 flex flex-col md:flex-row gap-6 items-center">
                <!-- Clock Widget -->
                <div class="flex flex-col items-center justify-center bg-gray-50 dark:bg-neutral-900/60 rounded-xl p-4 w-full md:w-36 text-center border border-gray-100 dark:border-neutral-800">
                    <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-neutral-500 tracking-wider">HARI INI</span>
                    <span class="text-3xl font-extrabold text-blue-600 dark:text-blue-500 my-1" id="pt-date">08</span>
                    <span class="text-xs font-semibold text-gray-600 dark:text-neutral-300" id="pt-month-year">Agt 2026</span>
                    <span class="text-xs text-gray-500 dark:text-neutral-400 mt-2 font-mono" id="pt-time">03:27:00</span>
                </div>
                <!-- PT Details Table -->
                <div class="flex-1 w-full">
                    <table class="w-full text-sm text-gray-600 dark:text-neutral-300 space-y-2">
                        <tbody>
                            <tr class="border-b border-gray-50 dark:border-neutral-700/40 pb-2">
                                <td class="py-2 font-medium flex items-center gap-2">
                                    <iconify-icon icon="solar:home-linear" class="text-blue-600 dark:text-blue-500"></iconify-icon>
                                    <span>Nama Perusahaan</span>
                                </td>
                                <td class="py-2 text-gray-800 dark:text-white font-bold text-end">LEON SELLULAR INDONESIA</td>
                            </tr>
                            <tr class="border-b border-gray-50 dark:border-neutral-700/40 pb-2">
                                <td class="py-2 font-medium flex items-center gap-2">
                                    <iconify-icon icon="solar:database-linear" class="text-emerald-500"></iconify-icon>
                                    <span>Nama Database</span>
                                </td>
                                <td class="py-2 text-gray-800 dark:text-white font-semibold text-end">leon</td>
                            </tr>
                            <tr class="border-b border-gray-50 dark:border-neutral-700/40 pb-2">
                                <td class="py-2 font-medium flex items-center gap-2">
                                    <iconify-icon icon="solar:branch-linear" class="text-amber-500"></iconify-icon>
                                    <span>Total Cabang</span>
                                </td>
                                <td class="py-2 text-gray-800 dark:text-white font-semibold text-end">1 Cabang</td>
                            </tr>
                            <tr class="border-b border-gray-50 dark:border-neutral-700/40 pb-2">
                                <td class="py-2 font-medium flex items-center gap-2">
                                    <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-indigo-500"></iconify-icon>
                                    <span>Total User</span>
                                </td>
                                <td class="py-2 text-gray-800 dark:text-white font-semibold text-end">10 Pengguna</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium flex items-center gap-2">
                                    <iconify-icon icon="solar:calendar-minimalistic-linear" class="text-orange-500"></iconify-icon>
                                    <span>Periode Awal</span>
                                </td>
                                <td class="py-2 text-gray-800 dark:text-white font-semibold text-end">JAN 2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terakhir Anda -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:history-linear" class="text-blue-600 dark:text-blue-500 text-lg"></iconify-icon>
                    <span>Aktivitas Terakhir Anda</span>
                </h3>
                <span class="text-xs text-gray-400 dark:text-neutral-500">Audit Trail</span>
            </div>
            <div class="p-0 overflow-y-auto max-h-56">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-700/40">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Waktu / Tanggal</th>
                            <th scope="col" class="px-5 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400">Deskripsi Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-700/60">
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-neutral-400 font-mono">07-08-2026 19:05:10</td>
                            <td class="px-5 py-3 text-xs text-gray-800 dark:text-neutral-200 font-medium">L01 - Maintenance Data Periode 08/2026 (Selesai)</td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-neutral-400 font-mono">07-08-2026 19:02:52</td>
                            <td class="px-5 py-3 text-xs text-gray-800 dark:text-neutral-200 font-medium">L01 - Maintenance Data Periode 08/2026 (Mulai)</td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-neutral-400 font-mono">07-08-2026 19:01:14</td>
                            <td class="px-5 py-3 text-xs text-gray-800 dark:text-neutral-200 font-medium">L01 - Ubah Faktur Pembelian PI2026080113</td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-neutral-400 font-mono">07-08-2026 19:01:12</td>
                            <td class="px-5 py-3 text-xs text-gray-800 dark:text-neutral-200 font-medium text-blue-600 dark:text-blue-500">L01 - Ubah Detail PI2026080113 (SAMSUNG GALAXY A07 5G 6/128GB BLACK)</td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-neutral-400 font-mono">07-08-2026 18:06:26</td>
                            <td class="px-5 py-3 text-xs text-gray-800 dark:text-neutral-200 font-medium">L01 - Ubah Faktur Pembelian PI2026080102</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Row 2: Best Seller & Keuangan Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Best Seller -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:star-fall-minimalistic-linear" class="text-yellow-500 text-lg"></iconify-icon>
                    <span>Produk Terlaris (Best Seller)</span>
                </h3>
            </div>
            <div class="p-5 flex flex-col md:flex-row items-center gap-6">
                <!-- Doughnut Chart Container -->
                <div class="w-full md:w-44 flex justify-center">
                    <canvas id="donut-graph" class="max-h-40 max-w-40"></canvas>
                </div>
                <!-- Best Seller Products Table -->
                <div class="flex-1 w-full overflow-x-auto">
                    <table class="w-full text-xs text-gray-600 dark:text-neutral-300">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-neutral-700 text-gray-400 dark:text-neutral-500 text-left">
                                <th class="pb-2 font-medium">No.</th>
                                <th class="pb-2 font-medium">Nama Barang</th>
                                <th class="pb-2 font-medium text-end">Nilai (Ribuan)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-neutral-700/40">
                            <tr>
                                <td class="py-2">1.</td>
                                <td class="py-2 font-semibold text-gray-800 dark:text-white">REALME 10 PRO+ 5G 12/256GB</td>
                                <td class="py-2 text-end font-bold text-blue-600">225,750</td>
                            </tr>
                            <tr>
                                <td class="py-2">2.</td>
                                <td class="py-2 font-semibold text-gray-800 dark:text-white">XIAOMI POCO C85 6/128GB BLACK</td>
                                <td class="py-2 text-end font-bold text-amber-500">202,745</td>
                            </tr>
                            <tr>
                                <td class="py-2">3.</td>
                                <td class="py-2 font-semibold text-gray-800 dark:text-white">INFINIX SMART 20 4/128 BLACK</td>
                                <td class="py-2 text-end font-bold text-emerald-500">137,578</td>
                            </tr>
                            <tr>
                                <td class="py-2">4.</td>
                                <td class="py-2 font-semibold text-gray-800 dark:text-white">APPLE IPHONE 15 128GB BLUE</td>
                                <td class="py-2 text-end font-bold text-rose-500">105,750</td>
                            </tr>
                            <tr>
                                <td class="py-2">5.</td>
                                <td class="py-2 font-semibold text-gray-800 dark:text-white">REALME C71 8/128 WHITE SWAN</td>
                                <td class="py-2 text-end font-bold text-indigo-500">100,443</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Keuangan Cards Grid -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:banknote-linear" class="text-emerald-500 text-lg"></iconify-icon>
                    <span>Informasi Nilai Keuangan</span>
                </h3>
                <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 font-mono">01-08-2026 s/d 07-08-2026</span>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1">
                <!-- Penjualan -->
                <div class="flex items-center gap-4 bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 rounded-xl p-4">
                    <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-emerald-500/20 text-emerald-600 dark:text-emerald-500">
                        <iconify-icon icon="solar:cart-large-4-linear" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-emerald-600 dark:text-emerald-500 uppercase tracking-wider">Penjualan</span>
                        <span class="block text-sm font-bold text-gray-800 dark:text-white mt-0.5">Rp 5.425.563.013,30</span>
                    </div>
                </div>

                <!-- Pembelian -->
                <div class="flex items-center gap-4 bg-rose-50/50 dark:bg-rose-955/20 border border-rose-100 dark:border-rose-900/30 rounded-xl p-4">
                    <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-rose-500/20 text-rose-600 dark:text-rose-500">
                        <iconify-icon icon="solar:bag-3-linear" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-rose-600 dark:text-rose-500 uppercase tracking-wider">Pembelian</span>
                        <span class="block text-sm font-bold text-gray-800 dark:text-white mt-0.5">Rp 7.868.810.158,94</span>
                    </div>
                </div>

                <!-- Piutang Dagang -->
                <div class="flex items-center gap-4 bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 rounded-xl p-4">
                    <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-emerald-500/20 text-emerald-600 dark:text-emerald-500">
                        <iconify-icon icon="solar:import-linear" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-emerald-600 dark:text-emerald-500 uppercase tracking-wider">Piutang Dagang (Outs)</span>
                        <span class="block text-sm font-bold text-gray-800 dark:text-white mt-0.5">Rp 107.486.981.986,15</span>
                    </div>
                </div>

                <!-- Hutang Dagang -->
                <div class="flex items-center gap-4 bg-rose-50/50 dark:bg-rose-955/20 border border-rose-100 dark:border-rose-900/30 rounded-xl p-4">
                    <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-rose-500/20 text-rose-600 dark:text-rose-500">
                        <iconify-icon icon="solar:export-linear" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-rose-600 dark:text-rose-500 uppercase tracking-wider">Hutang Dagang (Outs)</span>
                        <span class="block text-sm font-bold text-gray-800 dark:text-white mt-0.5">Rp 13.937.212.123,94</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Hutang vs Piutang & Laba Rugi Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Hutang vs Piutang -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:chart-square-linear" class="text-blue-600 dark:text-blue-500 text-lg"></iconify-icon>
                    <span>Pembayaran Hutang vs Penerimaan Piutang</span>
                </h3>
                <span class="text-xs text-gray-400 dark:text-neutral-500 font-semibold font-mono">W2: 02 - 08</span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-center">
                <canvas id="HvP" class="max-h-56 w-full"></canvas>
            </div>
        </div>

        <!-- Laba Rugi -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <iconify-icon icon="solar:graph-up-linear" class="text-emerald-500 text-lg"></iconify-icon>
                    <span>Tren Laba / Rugi Perusahaan</span>
                </h3>
                <span class="text-xs text-gray-400 dark:text-neutral-500 font-semibold font-mono">W2: 02 - 08</span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-center">
                <canvas id="lr_tp" class="max-h-56 w-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN for interactive charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Running Clock & Chart Initialization scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Running Clock Logic
            function updateClock() {
                const now = new Date();
                
                // Format Hari dan Tanggal untuk Header
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                
                const dayName = days[now.getDay()];
                const dateNum = String(now.getDate()).padStart(2, '0');
                const monthName = months[now.getMonth()];
                const year = now.getFullYear();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                
                const formattedTime = `${hours}:${minutes}:${seconds}`;
                const formattedDateFull = `${dayName}, ${dateNum} ${monthName} ${year} • ${formattedTime}`;
                
                // Set text ke display clock
                const clockEl = document.getElementById('running-clock-display');
                if (clockEl) clockEl.innerText = formattedDateFull;
                
                // Set text ke Widget Perusahaan
                const ptDateEl = document.getElementById('pt-date');
                const ptMonthYearEl = document.getElementById('pt-month-year');
                const ptTimeEl = document.getElementById('pt-time');
                
                if (ptDateEl) ptDateEl.innerText = dateNum;
                if (ptMonthYearEl) ptMonthYearEl.innerText = `${monthName.substring(0, 3)} ${year}`;
                if (ptTimeEl) ptTimeEl.innerText = formattedTime;
            }
            
            // Jalankan jam berjalan setiap 1 detik
            setInterval(updateClock, 1000);
            updateClock(); // jalankan pertama kali
            
            // 2. Chart.js: Donut Chart (Best Seller)
            const donutCtx = document.getElementById('donut-graph').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['REALME 10 PRO+', 'XIAOMI POCO C85', 'INFINIX SMART 20', 'APPLE IPHONE 15', 'REALME C71'],
                    datasets: [{
                        data: [225750, 202745, 137578, 105750, 100443],
                        backgroundColor: [
                            '#3b82f6', // blue
                            '#f59e0b', // amber
                            '#10b981', // emerald
                            '#ef4444', // rose
                            '#6366f1'  // indigo
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
            
            // 3. Chart.js: Bar Chart (Hutang vs Piutang)
            const hvpCtx = document.getElementById('HvP').getContext('2d');
            new Chart(hvpCtx, {
                type: 'bar',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [
                        {
                            label: 'Pembayaran Hutang',
                            data: [1.2, 1.8, 1.5, 0.9, 2.1, 1.3, 1.6], // dalam jutaan/miliar
                            backgroundColor: '#ef4444',
                            borderRadius: 4
                        },
                        {
                            label: 'Penerimaan Piutang',
                            data: [1.9, 2.2, 2.4, 1.8, 2.8, 2.1, 2.3],
                            backgroundColor: '#3b82f6',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
            
            // 4. Chart.js: Line Chart (Laba/Rugi)
            const lrCtx = document.getElementById('lr_tp').getContext('2d');
            new Chart(lrCtx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [
                        {
                            label: 'Laba',
                            data: [80, 110, 125, 95, 140, 105, 115],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Rugi',
                            data: [5, 8, 12, 6, 15, 4, 9],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

<div class="w-full mx-auto px-4 flex items-center justify-between" aria-label="Global">
    <!-- Hamburger & Search -->
    <div class="flex items-center gap-4">
        <!-- Navigation Toggle (Hamburger) -->
        <button type="button" 
            class="lg:hidden text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 rounded-lg p-2 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:ring-neutral-700" 
            data-hs-overlay="#application-sidebar-brand" 
            aria-controls="application-sidebar-brand" 
            aria-label="Toggle navigation">
            <iconify-icon icon="solar:hamburger-menu-linear" class="text-2xl"></iconify-icon>
        </button>

        <!-- Search Bar -->
        <div class="relative hidden sm:block">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                <iconify-icon icon="solar:minimalistic-magnifer-linear" class="text-gray-400 text-lg"></iconify-icon>
            </div>
            <input type="text" class="py-2 pe-4 ps-10 block w-60 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Pencarian global...">
        </div>
    </div>

    <!-- Right Controls -->
    <div class="flex items-center gap-3">
        <!-- Tenant Switcher Dropdown -->
        <div class="hs-dropdown relative inline-flex">
            <button id="hs-dropdown-tenant" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                <iconify-icon icon="solar:shop-2-linear" class="text-blue-500 text-base"></iconify-icon>
                <span class="max-w-[120px] truncate">Leon Sellular Indonesia</span>
                <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs"></iconify-icon>
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border-neutral-700" aria-labelledby="hs-dropdown-tenant">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">
                    <span class="block text-xs text-gray-400 dark:text-neutral-500">PILIH DATABASE PT</span>
                </div>
                <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 bg-gray-50 dark:text-neutral-200 dark:bg-neutral-700" href="#">
                    <iconify-icon icon="solar:check-circle-bold" class="text-green-500 text-lg"></iconify-icon>
                    <div class="flex flex-col">
                        <span class="font-medium">Leon Sellular Indonesia</span>
                        <span class="text-[10px] text-gray-400">1 Cabang • expired: 09/12/2026</span>
                    </div>
                </a>
                <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300" href="#">
                    <iconify-icon icon="solar:shop-linear" class="text-gray-400 text-lg"></iconify-icon>
                    <div class="flex flex-col">
                        <span class="font-medium">PT. Enam Jalan Dewa</span>
                        <span class="text-[10px] text-gray-400">1 Cabang • expired: 09/12/2026</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Dark Mode Toggle -->
        <button type="button" onclick="toggleTheme('dark')" class="hs-dark-mode-active:hidden block text-gray-500 hover:text-gray-600 focus:outline-none rounded-lg p-2 dark:text-neutral-400 dark:hover:text-neutral-300" id="dark-theme-toggle">
            <iconify-icon icon="solar:moon-linear" class="text-xl"></iconify-icon>
        </button>
        <button type="button" onclick="toggleTheme('light')" class="hs-dark-mode-active:block hidden text-gray-500 hover:text-gray-600 focus:outline-none rounded-lg p-2 dark:text-neutral-400 dark:hover:text-neutral-300" id="light-theme-toggle">
            <iconify-icon icon="solar:sun-2-linear" class="text-xl"></iconify-icon>
        </button>

        <!-- Notification Dropdown -->
        <div class="hs-dropdown relative inline-flex">
            <button id="hs-dropdown-notifications" type="button" class="relative text-gray-500 hover:text-gray-600 focus:outline-none rounded-lg p-2 dark:text-neutral-400 dark:hover:text-neutral-300">
                <iconify-icon icon="solar:bell-linear" class="text-xl"></iconify-icon>
                <span class="absolute top-1 right-1 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden w-80 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border-neutral-700" aria-labelledby="hs-dropdown-notifications">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">Notifikasi</span>
                    <a href="#" class="text-xs text-blue-500 hover:underline">Tandai dibaca</a>
                </div>
                <div class="p-2 space-y-1">
                    <a class="flex gap-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700" href="#">
                        <iconify-icon icon="solar:info-square-linear" class="text-blue-500 text-xl shrink-0"></iconify-icon>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium">Stok barang hampir habis</span>
                            <span class="text-[10px] text-gray-400">iPhone 14 Pro Sisa 2 Unit</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="hs-dropdown relative inline-flex">
            <button id="hs-dropdown-user" type="button" class="hs-dropdown-toggle flex items-center gap-2 focus:outline-none">
                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-gray-200 dark:ring-neutral-700" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-44 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border-neutral-700" aria-labelledby="hs-dropdown-user">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">
                    <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="block text-xs text-gray-400 dark:text-neutral-500">{{ Auth::user()->email ?? 'admin@leonphone.test' }}</span>
                </div>
                <a class="flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300" href="#">
                    <iconify-icon icon="solar:user-linear" class="text-lg"></iconify-icon>
                    Profil Saya
                </a>
                <a class="flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300" href="#">
                    <iconify-icon icon="solar:key-linear" class="text-lg"></iconify-icon>
                    Ganti Password
                </a>
                <hr class="my-1 border-gray-200 dark:border-neutral-700">
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-900/30 text-start">
                        <iconify-icon icon="solar:logout-linear" class="text-lg"></iconify-icon>
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

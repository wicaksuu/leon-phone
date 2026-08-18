<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-boxed-layout="boxed" data-card="shadow">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leon Phone RMS') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Iconify Icon CDN -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <!-- Preline Dark/Light Mode Switcher Script -->
    <script>
        // Inisialisasi tema sebelum halaman dirender untuk menghindari kedipan putih (FOUC)
        (function() {
            const theme = localStorage.getItem('hs_theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        // Fungsi toggle tema global
        function toggleTheme(theme) {
            const html = document.documentElement;
            const darkToggle = document.getElementById('dark-theme-toggle');
            const lightToggle = document.getElementById('light-theme-toggle');

            if (theme === 'dark') {
                html.classList.add('dark');
                localStorage.setItem('hs_theme', 'dark');
                if (darkToggle) darkToggle.style.display = 'none';
                if (lightToggle) lightToggle.style.display = 'block';
            } else {
                html.classList.remove('dark');
                localStorage.setItem('hs_theme', 'light');
                if (darkToggle) darkToggle.style.display = 'block';
                if (lightToggle) lightToggle.style.display = 'none';
            }
        }

        // Sinkronisasi status tampilan tombol pertama kali saat DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('hs_theme') || 'light';
            const darkToggle = document.getElementById('dark-theme-toggle');
            const lightToggle = document.getElementById('light-theme-toggle');

            if (theme === 'dark') {
                if (darkToggle) darkToggle.style.display = 'none';
                if (lightToggle) lightToggle.style.display = 'block';
            } else {
                if (darkToggle) darkToggle.style.display = 'block';
                if (lightToggle) lightToggle.style.display = 'none';
            }
        });
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-neutral-900 text-gray-800 dark:text-neutral-200 antialiased">
    <div id="main-wrapper" class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="application-sidebar-brand" 
            class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-neutral-800 dark:border-neutral-700 transition-all duration-300">
            <x-sidebar />
        </aside>

        <!-- Page Wrapper -->
        <div class="lg:ps-64 w-full flex flex-col">
            <!-- Header -->
            <header class="sticky top-0 inset-x-0 z-50 flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white border-b border-gray-200 text-sm py-2.5 sm:py-4 dark:bg-neutral-800 dark:border-neutral-700">
                <x-header />
            </header>

            <!-- Main Content Area -->
            <main class="w-full grow p-4 sm:p-6 space-y-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

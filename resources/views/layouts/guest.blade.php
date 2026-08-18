<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
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
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="mb-6 flex flex-col items-center">
            <a href="/" class="flex items-center gap-2 text-3xl font-bold text-blue-600 dark:text-blue-500">
                <iconify-icon icon="solar:phone-calling-bold" class="text-4xl"></iconify-icon>
                <span>LEON PHONE</span>
            </a>
            <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">Retail Management System (RMS)</p>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md bg-white border border-gray-200 shadow-md rounded-xl p-6 sm:p-8 dark:bg-neutral-800 dark:border-neutral-700">
            {{ $slot }}
        </div>
    </div>
</body>
</html>

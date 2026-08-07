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
        const HSThemeAppearance = {
            init() {
                const defaultTheme = 'default'
                let theme = localStorage.getItem('hs_theme') || defaultTheme

                if (document.querySelector('html').classList.contains('dark')) return
                this.setAppearance(theme)
            },
            _removeClasses() {
                document.querySelector('html').classList.remove('dark')
                document.querySelector('html').classList.remove('default')
            },
            setAppearance(theme, saveInStore = true, dispatchEvent = true) {
                const html = document.querySelector('html')
                this._removeClasses()

                if (theme === 'dark') {
                    html.classList.add('dark')
                } else if (theme === 'default') {
                    html.classList.add('default')
                }

                if (saveInStore) {
                    localStorage.setItem('hs_theme', theme)
                }

                if (dispatchEvent) {
                    window.dispatchEvent(new CustomEvent('on-hs-appearance-change', { detail: theme }))
                }
            },
            getAppearance() {
                let theme = localStorage.getItem('hs_theme')
                if (theme) return theme
                return 'default'
            }
        }

        HSThemeAppearance.init()

        window.addEventListener('load', () => {
            const $clickableThemes = document.querySelectorAll('[data-hs-theme-click-value]')
            const $switchableThemes = document.querySelectorAll('[data-hs-theme-switch]')

            $clickableThemes.forEach($item => {
                $item.addEventListener('click', () => {
                    const theme = $item.getAttribute('data-hs-theme-click-value')
                    HSThemeAppearance.setAppearance(theme === 'light' ? 'default' : theme)
                })
            })

            $switchableThemes.forEach($item => {
                $item.addEventListener('change', (e) => {
                    HSThemeAppearance.setAppearance(e.target.checked ? 'dark' : 'default')
                })
            })
        })
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

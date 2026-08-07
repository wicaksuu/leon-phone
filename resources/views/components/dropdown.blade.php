@props([
    'id',
    'label' => 'Dropdown Button'
])

<div class="hs-dropdown relative inline-flex">
    <button id="{{ $id }}" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
        <span>{{ $label }}</span>
        <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs"></iconify-icon>
    </button>

    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-48 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70" role="menu" aria-orientation="vertical" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </div>
</div>

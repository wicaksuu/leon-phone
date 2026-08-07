@props([
    'variant' => 'success',
    'message' => ''
])

@php
    $baseClasses = 'max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700';
    
    $icons = [
        'success' => ['icon' => 'solar:check-circle-bold', 'color' => 'text-green-500'],
        'warning' => ['icon' => 'solar:danger-bold', 'color' => 'text-yellow-500'],
        'error' => ['icon' => 'solar:close-circle-bold', 'color' => 'text-red-500'],
        'danger' => ['icon' => 'solar:close-circle-bold', 'color' => 'text-red-500'],
        'info' => ['icon' => 'solar:info-square-bold', 'color' => 'text-blue-500']
    ];

    $selectedIcon = $icons[$variant] ?? $icons['success'];
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }} role="alert" tabindex="-1">
    <div class="flex p-4">
        <div class="shrink-0">
            <iconify-icon icon="{{ $selectedIcon['icon'] }}" class="{{ $selectedIcon['color'] }} text-xl"></iconify-icon>
        </div>
        <div class="ms-3">
            <p class="text-sm text-gray-700 dark:text-neutral-400">
                {{ $slot->isEmpty() ? $message : $slot }}
            </p>
        </div>
    </div>
</div>

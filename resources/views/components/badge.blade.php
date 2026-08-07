@props([
    'variant' => 'info'
])

@php
    $baseClasses = 'inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full text-xs font-semibold';
    
    $variants = [
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
        'error' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-500',
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-neutral-800 dark:text-neutral-400'
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['info']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

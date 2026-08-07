@props([
    'variant' => 'primary',
    'type' => 'button'
])

@php
    $baseClasses = 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent disabled:opacity-50 disabled:pointer-events-none transition-all duration-200';
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500',
        'secondary' => 'bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:bg-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-600 dark:focus:ring-neutral-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500',
        'outline' => 'border-gray-200 text-gray-800 hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800'
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>

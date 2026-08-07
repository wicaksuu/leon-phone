@props([
    'id' => null,
    'name' => null,
    'title' => 'Modal Title',
    'show' => false,
    'focusable' => false
])

@php
    $modalId = $id ?? $name ?? 'modal-' . uniqid();
@endphp

<div id="{{ $modalId }}" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="{{ $modalId }}-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
        <div class="w-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <!-- Modal Header -->
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                <h3 id="{{ $modalId }}-label" class="font-bold text-gray-800 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" class="flex justify-center items-center h-8 w-8 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#{{ $modalId }}">
                    <span class="sr-only">Tutup</span>
                    <iconify-icon icon="solar:close-square-linear" class="text-xl"></iconify-icon>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-4 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

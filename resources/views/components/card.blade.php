@props([
    'title' => null,
    'subtitle' => null
])

<div {{ $attributes->merge(['class' => 'flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700']) }}>
    @if ($title || $slot->isNotEmpty())
        <div class="p-4 md:p-5">
            @if ($title)
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $title }}
                </h3>
            @endif
            @if ($subtitle)
                <p class="mt-1 text-xs text-gray-500 dark:text-neutral-500">
                    {{ $subtitle }}
                </p>
            @endif
            
            <div class="mt-4">
                {{ $slot }}
            </div>
        </div>
    @endif
</div>

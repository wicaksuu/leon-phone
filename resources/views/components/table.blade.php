<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 dark:divide-neutral-700']) }}>
                    {{ $slot }}
                </table>
            </div>
        </div>
    </div>
</div>

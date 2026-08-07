<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    // TelescopeServiceProvider is intentionally NOT registered here — it's
    // conditionally registered in AppServiceProvider, local/staging only.
    // See docs/00-status.md #13: Telescope must never boot in production.
];

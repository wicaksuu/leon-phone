<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Support\TenantContext;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TenantContext::class);

        // docs/00-status.md #13 / docs/03-architecture.md § Observability &
        // Realtime — Telescope is local/staging only. Registered
        // conditionally here (not in bootstrap/providers.php) so it never
        // boots at all in production, not just gets access-gated.
        if ($this->app->environment('local', 'staging')) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

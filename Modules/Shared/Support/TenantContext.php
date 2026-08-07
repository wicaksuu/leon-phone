<?php

namespace Modules\Shared\Support;

use Filament\Facades\Filament;
use Modules\Shared\Models\Tenant;

/**
 * Single source of truth for "which tenant is active right now".
 *
 * Filament resolves the tenant automatically via its own panel tenancy (route
 * model binding), so this class defers to Filament::getTenant() by default.
 * The manual override exists for contexts Filament doesn't cover: artisan
 * commands, queued jobs, tests, and the future API entry point
 * (docs/08-tenancy.md) — all of them are expected to call set() explicitly
 * before touching any tenant-scoped model.
 */
class TenantContext
{
    protected ?Tenant $tenant = null;

    protected bool $manuallySet = false;

    public function set(?Tenant $tenant): void
    {
        $this->tenant = $tenant;
        $this->manuallySet = true;
    }

    public function get(): ?Tenant
    {
        if ($this->manuallySet) {
            return $this->tenant;
        }

        if (Filament::isServing()) {
            /** @var Tenant|null $tenant */
            $tenant = Filament::getTenant();

            return $tenant;
        }

        return null;
    }

    public function id(): ?int
    {
        return $this->get()?->id;
    }
}

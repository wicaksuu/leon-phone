<?php

namespace Modules\Shared\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shared\Models\Tenant;
use Modules\Shared\Support\TenantContext;

/**
 * Attach to every tenant-scoped model (docs/08-tenancy.md). Auto-fills
 * tenant_id on create and auto-scopes every query to the active tenant
 * resolved by TenantContext — never trust a tenant_id passed in from a
 * form/request body (CLAUDE.md rule #8).
 */
trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::creating(function ($model): void {
            if ($model->tenant_id === null) {
                $model->tenant_id = app(TenantContext::class)->id();
            }
        });

        static::addGlobalScope('tenant', function (Builder $query): void {
            if ($tenantId = app(TenantContext::class)->id()) {
                $query->where($query->getModel()->getTable().'.tenant_id', $tenantId);
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}

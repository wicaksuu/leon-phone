<?php

namespace Modules\Shared\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Shared\Models\AuditLog;
use Modules\Shared\Support\TenantContext;

/**
 * Generic — attach via Modules\Shared\Traits\Auditable, never write
 * AuditLog rows by hand (docs/04-database.md § Audit log).
 */
class AuditLogObserver
{
    public function created(Model $model): void
    {
        $this->log($model, 'created', null, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $changes = $model->getChanges();
        unset($changes['updated_at']);

        if ($changes === []) {
            return;
        }

        $old = array_intersect_key($model->getOriginal(), $changes);

        $this->log($model, 'updated', $old, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'deleted', $model->getAttributes(), null);
    }

    protected function log(Model $model, string $action, ?array $old, ?array $new): void
    {
        AuditLog::create([
            'tenant_id' => $model->getAttribute('tenant_id') ?? app(TenantContext::class)->id(),
            'auditable_type' => $model->getMorphClass(),
            'auditable_id' => $model->getKey(),
            'actor_id' => Auth::id(),
            'action' => $action,
            'old_values' => $old,
            'new_values' => $new,
            'created_at' => now(),
        ]);
    }
}

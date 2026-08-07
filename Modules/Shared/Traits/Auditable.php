<?php

namespace Modules\Shared\Traits;

use Modules\Shared\Observers\AuditLogObserver;

/**
 * Attach to any model whose created/updated/deleted events must be
 * traceable (CLAUDE.md rule: "setiap perubahan data — stok, harga, order,
 * user — tercatat lengkap"). Opt-in per model, not automatic — not every
 * model needs an audit trail (e.g. cached/derived rows don't).
 *
 * Registers listeners directly instead of via static::observe(), because
 * Model::observe() does `new static` internally — called from inside a
 * boot{Trait} hook, on the model that is itself mid-boot, that throws
 * "bootIfNotBooted... while it is being booted" (Laravel's own re-entrancy
 * guard). created()/updated()/deleted() just register with the event
 * dispatcher, no model instantiation involved.
 */
trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(fn ($model) => app(AuditLogObserver::class)->created($model));
        static::updated(fn ($model) => app(AuditLogObserver::class)->updated($model));
        static::deleted(fn ($model) => app(AuditLogObserver::class)->deleted($model));
    }
}

<?php

namespace Modules\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Append-only (docs/04-database.md § Prinsip #1) — never update or delete a
 * row here. Written exclusively by Modules\Shared\Observers\AuditLogObserver,
 * never by hand.
 */
class AuditLog extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    protected $fillable = [
        'tenant_id',
        'auditable_type',
        'auditable_id',
        'actor_id',
        'action',
        'old_values',
        'new_values',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}

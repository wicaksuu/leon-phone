<?php

namespace Modules\MasterData\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shared\Traits\Auditable;
use Modules\Shared\Traits\BelongsToTenant;

/**
 * Gudang. tenant_id is denormalized here on purpose (docs/04-database.md) so
 * tenant-scoped queries never need to join through Branch just to filter.
 */
class Warehouse extends Model
{
    use Auditable, BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'name',
        'code',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}

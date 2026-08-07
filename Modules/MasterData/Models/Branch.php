<?php

namespace Modules\MasterData\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shared\Traits\Auditable;
use Modules\Shared\Traits\BelongsToTenant;

/**
 * Cabang. Sits between Tenant and Warehouse: PT -> Cabang -> Gudang
 * (docs/04-database.md § Tenancy & lokasi).
 */
class Branch extends Model
{
    use Auditable, BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'code',
        'address',
    ];

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }
}

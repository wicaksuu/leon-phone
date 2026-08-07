<?php

namespace Modules\Shared\Models;

use App\Models\User;
use Database\Factories\TenantFactory;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MasterData\Models\Branch;

/**
 * A tenant is one PT (company). See docs/08-tenancy.md — shared database,
 * every business table carries tenant_id, isolation is enforced by
 * Modules\Shared\Traits\BelongsToTenant, not by separate databases.
 */
class Tenant extends Model implements HasName
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'logo_path',
        'subscription_status',
        'subscription_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'subscription_expires_at' => 'datetime',
        ];
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    protected static function newFactory(): TenantFactory
    {
        // Overridden because Tenant lives outside App\Models — Laravel's
        // default factory-name resolution only looks under App\Database\Factories.
        return TenantFactory::new();
    }
}

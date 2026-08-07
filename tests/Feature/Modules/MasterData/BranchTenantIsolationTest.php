<?php

namespace Tests\Feature\Modules\MasterData;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Modules\MasterData\Models\Branch;
use Modules\Shared\Models\Tenant;
use Modules\Shared\Support\TenantContext;
use RuntimeException;
use Tests\TestCase;

/**
 * docs/08-tenancy.md § Testing wajib — every feature touching business data
 * needs at least one test proving tenant isolation, including direct
 * by-ID access, not just listings. This also doubles as the reference
 * example for docs/05-coding-standards.md § 4b (Feature/Integration test).
 */
class BranchTenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_branch_auto_fills_tenant_id_from_context(): void
    {
        $tenant = Tenant::factory()->create();
        app(TenantContext::class)->set($tenant);

        $branch = Branch::create(['name' => 'Cabang Utama', 'code' => 'CB01']);

        $this->assertSame($tenant->id, $branch->tenant_id);
    }

    public function test_a_tenant_cannot_see_another_tenants_branches_in_a_listing(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        app(TenantContext::class)->set($tenantA);
        Branch::create(['name' => 'Cabang A', 'code' => 'CB01']);

        app(TenantContext::class)->set($tenantB);
        Branch::create(['name' => 'Cabang B', 'code' => 'CB01']);

        $this->assertCount(1, Branch::all());
        $this->assertSame('Cabang B', Branch::first()->name);
    }

    public function test_a_tenant_cannot_fetch_another_tenants_branch_directly_by_id(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        app(TenantContext::class)->set($tenantA);
        $branchOfTenantA = Branch::create(['name' => 'Cabang A', 'code' => 'CB01']);

        app(TenantContext::class)->set($tenantB);

        // The record exists (proven with withoutGlobalScopes below), but is
        // invisible to tenant B's own query — this is the exact failure
        // mode the global scope in BelongsToTenant exists to prevent.
        $this->assertNull(Branch::find($branchOfTenantA->id));
        $this->assertNotNull(Branch::withoutGlobalScopes()->find($branchOfTenantA->id));
    }

    public function test_a_failed_multi_step_operation_rolls_back_completely(): void
    {
        $tenant = Tenant::factory()->create();
        app(TenantContext::class)->set($tenant);

        try {
            DB::transaction(function (): void {
                Branch::create(['name' => 'Cabang Yang Batal', 'code' => 'CB01']);

                // Simulates a later step in a Service failing (e.g. stock
                // check, IMEI validation) — see the ReceivePurchaseOrderService
                // pattern in docs/05-coding-standards.md § 2.
                throw new RuntimeException('Simulated failure mid-transaction.');
            });
        } catch (RuntimeException) {
            // expected — assertions happen below, outside the transaction.
        }

        $this->assertSame(0, Branch::count());
    }
}

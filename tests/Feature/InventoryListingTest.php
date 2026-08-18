<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryListingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji bahwa tamu (user belum login) akan dialihkan ke halaman masuk (login)
     * saat mengakses halaman-halaman persediaan.
     */
    public function test_guest_is_redirected_to_login_for_inventory_routes(): void
    {
        $routes = [
            '/inventory/units',
            '/inventory/sizes',
            '/inventory/goods-groups',
            '/inventory/brands',
            '/inventory/goods',
            '/inventory/sales-price-groups',
            '/inventory/warehouses',
            '/inventory/print-barcode',
            '/inventory/stock-opnames',
            '/inventory/transfers-temp',
            '/inventory/transfers-wh',
            '/inventory/adjust-stocks',
            '/inventory/assembly/raw-materials',
            '/inventory/assembly/fin-materials',
            '/inventory/sn-status',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    /**
     * Uji bahwa user yang terautentikasi dapat melihat 15 halaman persediaan dengan sukses.
     */
    public function test_authenticated_user_can_view_all_inventory_pages(): void
    {
        $user = User::factory()->create();

        // 1. Master Satuan
        $response = $this->actingAs($user)->get('/inventory/units');
        $response->assertStatus(200);
        $response->assertSee('Master Satuan (Units)');
        $response->assertSee('Pieces / Satuan Eceran');

        // 2. Master Ukuran
        $response = $this->actingAs($user)->get('/inventory/sizes');
        $response->assertStatus(200);
        $response->assertSee('Master Ukuran (Sizes)');
        $response->assertSee('6.1 INCH');

        // 3. Kelompok Barang
        $response = $this->actingAs($user)->get('/inventory/goods-groups');
        $response->assertStatus(200);
        $response->assertSee('Kelompok Barang (Goods Groups)');
        $response->assertSee('Handphone');

        // 4. Master Brand
        $response = $this->actingAs($user)->get('/inventory/brands');
        $response->assertStatus(200);
        $response->assertSee('Master Brand (Brands)');
        $response->assertSee('Realme');

        // 5. Master Barang
        $response = $this->actingAs($user)->get('/inventory/goods');
        $response->assertStatus(200);
        $response->assertSee('Master Barang (Goods)');
        $response->assertSee('REALME 10 PRO+ 5G');

        // 6. Kelompok Harga Jual
        $response = $this->actingAs($user)->get('/inventory/sales-price-groups');
        $response->assertStatus(200);
        $response->assertSee('Kelompok Std. Harga Jual');
        $response->assertSee('STD-RETAIL');

        // 7. Master Gudang
        $response = $this->actingAs($user)->get('/inventory/warehouses');
        $response->assertStatus(200);
        $response->assertSee('Master Gudang (Warehouses)');
        $response->assertSee('PT SUPER LEON');

        // 8. Cetak Barcode
        $response = $this->actingAs($user)->get('/inventory/print-barcode');
        $response->assertStatus(200);
        $response->assertSee('Cetak Barcode Label');
        $response->assertSee('Default Printer');

        // 9. Stok Opname
        $response = $this->actingAs($user)->get('/inventory/stock-opnames');
        $response->assertStatus(200);
        $response->assertSee('Transaksi Stok Opname');
        $response->assertSee('SO-2026/08-0001');

        // 10. Transfer Sementara
        $response = $this->actingAs($user)->get('/inventory/transfers-temp');
        $response->assertStatus(200);
        $response->assertSee('Transfer Sementara (Temp Transfers)');
        $response->assertSee('TRANSIT SERVICE');

        // 11. Transfer Gudang
        $response = $this->actingAs($user)->get('/inventory/transfers-wh');
        $response->assertStatus(200);
        $response->assertSee('Transfer Antar Gudang (Warehouse Transfers)');
        $response->assertSee('TF-WH-2026/08-0112');

        // 12. Penyesuaian Persediaan
        $response = $this->actingAs($user)->get('/inventory/adjust-stocks');
        $response->assertStatus(200);
        $response->assertSee('Penyesuaian Persediaan (Stock Adjustments)');
        $response->assertSee('ADJ-2026/08-0004');

        // 13. Perakitan - Pemakaian Bahan
        $response = $this->actingAs($user)->get('/inventory/assembly/raw-materials');
        $response->assertStatus(200);
        $response->assertSee('Perakitan § Pemakaian Bahan Baku');
        $response->assertSee('RM-2026/08-0002');

        // 14. Perakitan - Barang Jadi
        $response = $this->actingAs($user)->get('/inventory/assembly/fin-materials');
        $response->assertStatus(200);
        $response->assertSee('Perakitan § Penyelesaian Barang Jadi');
        $response->assertSee('FM-2026/08-0002');

        // 15. Laporan Status S/N
        $response = $this->actingAs($user)->get('/inventory/sn-status');
        $response->assertStatus(200);
        $response->assertSee('Laporan Status S/N');
        $response->assertSee('Hasil Pelacakan S/N');
    }
}

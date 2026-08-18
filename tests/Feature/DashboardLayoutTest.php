<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardLayoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji bahwa tamu (user belum login) akan dialihkan ke halaman masuk (login).
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Uji bahwa user yang terautentikasi dapat melihat dashboard dengan tata letak kustom dan komponen UI.
     */
    public function test_authenticated_user_can_view_dashboard_with_layout_and_components(): void
    {
        // Buat user contoh
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@leonphone.test',
        ]);

        // Kirim request terautentikasi ke dashboard
        $response = $this->actingAs($user)->get('/dashboard');

        // Pastikan respon sukses (HTTP 200)
        $response->assertStatus(200);

        // Verifikasi keberadaan teks branding utama di sidebar
        $response->assertSee('LEON PHONE');

        // Verifikasi keberadaan komponen-komponen UI Kit yang baru dibuat
        $response->assertSee('Info Data Perusahaan');
        $response->assertSee('LEON SELLULAR INDONESIA');
        $response->assertSee('Aktivitas Terakhir Anda');
        $response->assertSee('Best Seller');
        
        // Verifikasi tabel dan baris data transaksi/produk simulasi
        $response->assertSee('REALME 10 PRO+');
        $response->assertSee('INFINIX SMART 20');
        
        // Verifikasi nilai statistik keuangan
        $response->assertSee('Penjualan');
        $response->assertSee('Pembelian');
        $response->assertSee('Piutang Dagang (Outs)');
        $response->assertSee('Hutang Dagang (Outs)');
    }
}

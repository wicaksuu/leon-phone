# 05 — Coding Standards

**Wajib dibaca sebelum menulis kode apapun di project ini.** Ini bukan saran, ini kontrak
yang dipakai untuk review semua PR/perubahan.

## 1. Error handling

### Exception per domain, bukan generik
Setiap modul punya `Exceptions/` sendiri, turunan dari base exception app
(`Modules/Shared/Exceptions/DomainException`, dibuat sekali di Fase 1):

```php
// Modules/Inventory/Exceptions/InsufficientStockException.php
final class InsufficientStockException extends DomainException
{
    public function __construct(string $productVariant, int $requested, int $available)
    {
        parent::__construct("Stok {$productVariant} tidak cukup: diminta {$requested}, tersedia {$available}.");
    }
}
```

Jangan `throw new \Exception('stok kurang')`. Alasan: exception generik tidak bisa
ditangani beda-beda per kasus di `Handler`, dan tidak informatif saat debugging log
produksi.

### Satu tempat menangani exception → response konsisten
`bootstrap/app.php` (atau `Handler` di versi Laravel yang dipakai) memetakan
`DomainException` turunan ke:
- **Filament**: notification merah dengan pesan exception, form tidak ke-reset kalau gagal.
- **Livewire (POS/Packing)**: event ke frontend → toast error, tanpa reload halaman.
- **API/webhook marketplace**: JSON `{ "error": { "code": ..., "message": ... } }` dengan
  HTTP status yang sesuai (422 untuk validasi domain, 409 untuk conflict/stok, dst).

### Fail loud, fail early
Validasi precondition di awal Action/Service (stok cukup? IMEI belum terjual? approval
sudah ada?) sebelum menyentuh database. Jangan biarkan operasi jalan setengah lalu gagal di
tengah — itu kenapa aturan #2 (transaction) wajib.

## 2. Database transaction & rollback

### Aturan keras
> **Setiap operasi yang menulis ke lebih dari satu tabel, atau menulis lalu memanggil efek
> samping eksternal (marketplace API, print, notifikasi), WAJIB dibungkus
> `DB::transaction()`.**

Pola standar di layer Service:

```php
// Modules/Purchasing/Services/ReceivePurchaseOrderService.php
public function receive(PurchaseOrder $po, array $items): void
{
    DB::transaction(function () use ($po, $items) {
        foreach ($items as $item) {
            $this->stockService->increase($item->variant, $item->warehouse, $item->qty);

            foreach ($item->imeis as $imei) {
                $this->imeiService->markReceived($imei, $po, $item->warehouse); // lempar ImeiAlreadyExistsException kalau duplikat
            }
        }

        $po->markAsReceived(); // update status PO
    });
    // Efek samping yang TIDAK butuh konsistensi transaksional (kirim notifikasi,
    // generate PDF) dipanggil SETELAH transaction commit, lewat event/listener —
    // bukan di dalam closure di atas.
}
```

Kenapa notifikasi/PDF di luar transaction: kalau exception dilempar setelah notifikasi
terkirim tapi sebelum commit, user akan dapat notifikasi palsu untuk operasi yang di-rollback.
Gunakan Laravel event (`DB::afterCommit()` atau event dengan `ShouldDispatchAfterCommit`)
untuk efek samping.

### Nested operation = satu transaction, bukan bertingkat
Kalau Service A memanggil Service B yang juga butuh transaction, biarkan Laravel
menangani nested transaction (savepoint otomatis) — tapi **hindari mendesain Service B
untuk dipanggil berdiri sendiri dari luar sebuah transaction yang lebih besar** kalau dia
sebenarnya selalu jadi bagian dari alur yang lebih besar itu. Kalau Service B memang harus
valid berdiri sendiri (dipanggil langsung dari Livewire/Filament juga), dia boleh punya
`DB::transaction()` sendiri — Laravel akan treat sebagai savepoint kalau dipanggil nested.

Test rollback untuk Service semacam ini masuk ke trio testing wajib § 4 di bawah — bukan
opsional tambahan.

## 3. Konsistensi kode

- **Actions** = satu operasi bisnis atomik, stateless, single `execute()`/`handle()` method.
  Dipakai saat operasi dipanggil dari banyak tempat (mis. `CreateImeiHistoryAction` dipakai
  dari Purchasing, Order, Return, Warranty).
- **Services** = orkestrasi beberapa Actions + transaction boundary. Ini yang dipanggil dari
  Controller/Livewire/Filament.
- **DTOs** untuk data yang lewat antar layer (bukan `array` mentah, bukan `Request` object
  yang dipassing ke Service — Service tidak boleh tahu soal HTTP).
- **Enums** (PHP native `enum`) untuk semua status (`OrderStatus`, `ImeiStatus`,
  `ApprovalStatus`, dll) — tidak ada magic string status di kode manapun.
- **Policy** untuk semua otorisasi, termasuk approval workflow (`can('approve', $request)`).
- Nama class/method Inggris, pesan yang tampil ke user (exception message, notification)
  Bahasa Indonesia.
- Static analysis (PHPStan/Larastan level tinggi) & code style (Laravel Pint) dijalankan di
  CI sebelum merge — disiapkan di Fase 1.

## 4. Testing — wajib 3 jenis untuk setiap fitur/endpoint baru

> Ini permintaan eksplisit user (`docs/00-status.md` #8), bukan cuma "best practice
> umum". PR yang menambah/mengubah Service, Action, Livewire component, atau Filament
> resource **dianggap belum selesai** tanpa ketiganya. Reviewer (AI atau manusia) berhak
> menolak PR yang cuma punya sebagian.

### a. Unit test
Target: Action/Service/Rule/Enum yang logic-nya bisa diuji terisolasi tanpa DB atau HTTP
(atau dengan DB in-memory/transaction rollback standar Laravel). Contoh: `OrderStatus`
enum tidak boleh transisi dari `Completed` balik ke `Draft` — ini murni logic, tidak perlu
HTTP request untuk membuktikannya.

### b. Feature / Integration test
Target: satu resource Filament atau satu Livewire component/route, end-to-end lewat HTTP
test client Laravel — assert status code/redirect, assert isi halaman/response, DAN assert
efek di database (termasuk rollback: request yang gagal di tengah tidak boleh menyisakan
data setengah jadi — lihat § 2 di atas). **Wajib juga mencakup isolasi tenant**
(`docs/08-tenancy.md` § Testing wajib) untuk fitur apapun yang menyentuh data bisnis —
bukan test tenancy terpisah, tapi bagian dari Feature test yang sama.

### c. k6 (load/performance test)
Target: aksi frekuensi tinggi atau yang rawan jadi bottleneck kalau banyak kasir/gudang
pakai bersamaan — minimal: POS checkout, scan IMEI (Packing Station & Receive Barang),
search produk/varian (autocomplete di POS), sinkronisasi marketplace. Kalau aksinya lewat
Livewire (bukan endpoint REST biasa), k6 tetap bisa hit HTTP endpoint yang dipanggil
Livewire di baliknya (`livewire/update`) atau, kalau perlu lebih presisi, expose endpoint
API tipis khusus untuk keperluan load test. Skrip k6 hidup di
`tests/k6/<modul>/<nama-aksi>.js`, jalan manual atau di CI terjadwal (bukan tiap PR —
terlalu berat) dengan threshold p95 latency yang disepakati per aksi (angka pastinya
ditentukan saat fitur itu dibangun, dicatat sebagai komentar di skrip k6-nya, bukan
didiamkan sebagai magic number).

### Kenapa tiga-tiganya, bukan cukup satu
Unit test membuktikan logic benar secara isolasi. Feature test membuktikan logic itu benar
ketika dipasang ke HTTP + DB sungguhan (termasuk rollback beneran jalan, bukan cuma
"seharusnya jalan" di kepala). k6 membuktikan itu semua tetap benar & cukup cepat ketika
dipakai banyak orang bersamaan — ini yang paling sering kelewat di RMS/POS karena jam
sibuk (banyak kasir checkout bersamaan, banyak staf gudang packing bersamaan) adalah
kondisi yang justru paling penting buat sistem ini, bukan kondisi normal sepi.

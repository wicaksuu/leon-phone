# 03 — Architecture

## Struktur folder modular

```
Modules/
├── Shared/          ← BelongsToTenant trait, TenantContext, DomainException base, dst — lihat 08-tenancy.md
├── Dashboard/
├── MasterData/
├── Inventory/
├── SerialNumber/      ← eks "Imei/", digeneralisasi (docs/00-status.md #18): IMEI cuma satu tipe identifier
├── Marketplace/
├── Order/
├── Pos/
├── Packing/
├── Return/
├── Warranty/
├── Service/
├── Crm/
├── Purchasing/
├── Finance/
├── Accounting/       ← modul baru, lihat 02-modules.md §18
├── Hr/
├── Report/
└── Setting/
```

Setiap modul (kecuali yang murni read-only seperti Report) punya sub-folder standar:

```
Modules/<Nama>/
├── Actions/        ← satu class = satu operasi bisnis atomik (mis. CreatePurchaseOrder)
├── DTOs/            ← data transfer object antar layer, hindari passing array mentah
├── Enums/            ← status (OrderStatus, SerialIdentifierType, dll) — PHP native enum, bukan string magic
├── Events/
├── Exceptions/       ← exception spesifik domain (lihat 05-coding-standards.md)
├── Jobs/             ← proses async (sinkronisasi marketplace, generate report berat)
├── Listeners/
├── Models/
├── Observers/
├── Policies/         ← otorisasi per model, dipakai juga oleh approval workflow
├── Repositories/      ← query kompleks yang dipakai berulang, opsional untuk CRUD sederhana
├── Requests/          ← FormRequest, validasi input
├── Resources/          ← API/Filament resource transformer
├── Rules/               ← validation rule custom
├── Services/             ← orkestrasi Actions, tempat DB::transaction() dipanggil
└── Traits/
```

**Aturan penempatan logic**: Controller/Livewire component/Filament resource **memanggil**
Service atau Action, tidak pernah menulis query/business rule langsung. Ini yang membuat
logic bisa dites tanpa HTTP layer dan bisa dipakai ulang lintas entry point (Filament, POS
Livewire, API webhook marketplace).

## Kapan Filament, kapan Livewire custom

> Riwayat: sempat direncanakan pecah jadi Filament (backend agent) + REST API/React
> (frontend agent) supaya 2 AI agent kerja paralel independen. **Dibatalkan** — balik ke
> satu codebase Laravel penuh (Filament + Livewire), lihat `docs/00-status.md` #12.

| Kriteria | Filament | Livewire custom |
|---|---|---|
| CRUD standar dengan form/table/filter | ✅ | |
| Approval workflow (list + detail + tombol approve/reject) | ✅ | |
| Report dengan tabel & chart | ✅ (Filament widgets) | |
| Butuh scan-scan berturut cepat (barcode/IMEI/Serial Number) dengan feedback instan | | ✅ |
| Alur linear ketat dengan validasi hard-stop (Packing Station) | | ✅ |
| Layar kasir dengan keyboard shortcut, split payment, print thermal | | ✅ |

Modul yang **seluruhnya** Filament: Master Data, Purchasing, Finance, Akuntansi, HR,
Report, Setting, Dashboard (widget bawaan Filament pas untuk stat card/chart di dashboard
admin — lihat referensi `ref-gambar/`), sebagian besar Inventory (Stock, Mutasi, Stock
Opname sebagai *review/approval* screen — proses scan-nya sendiri tetap custom).

Modul yang **seluruhnya/sebagian besar** custom Livewire: POS Kasir, Packing Station, layar
scan unit (IMEI/Serial Number) saat Receive Barang, layar scan saat Stock Opname. Livewire
component ini bisa ditempel sebagai Filament custom page (tetap dalam satu panel/navigasi)
atau route Livewire mandiri — detail teknis diputuskan saat mulai coding, bukan sekarang.

Modul campuran: Order Management (list & detail = Filament, tapi aksi-aksi cepat seperti
"tandai picking" bisa custom); Marketplace (konfigurasi & log = Filament, webhook
ingestion = job/queue, bukan UI sama sekali).

## Marketplace Engine

Setiap marketplace punya adapter sendiri yang mengimplementasikan satu interface kontrak
(`MarketplaceAdapterInterface`): `fetchOrders()`, `pushStock()`, `updateOrderStatus()`, dll.
Engine tidak tahu detail Shopee vs Tokopedia — dia hanya memanggil interface itu dan
menyerap hasilnya menjadi record `Order` yang seragam. Adapter baru = implementasi baru,
tidak menyentuh kode Order Management yang sudah ada.

## Desain untuk error handling & transaksi (ringkas — detail penuh di 05)

- Semua operasi lintas-tabel dibungkus `DB::transaction()` di layer **Service**, bukan di
  Controller/Livewire.
- Exception domain-spesifik dilempar dari dalam transaksi → Laravel otomatis rollback →
  Service menangkap ulang untuk memberi pesan yang jelas ke caller.

## Queue & job

Sinkronisasi marketplace, generate report berat, dan notifikasi berjalan lewat queue
(`Jobs/` per modul), bukan inline di request cycle — supaya POS Kasir/Packing Station tidak
pernah lambat gara-gara proses background.

## API layer

Endpoint API (dipakai untuk webhook marketplace, dan opsional untuk app mobile staf gudang
di masa depan — bukan sebagai primary interface, lihat `docs/00-status.md` #12) hidup di
`routes/api.php`, memanggil Service yang sama dengan yang dipakai Filament/Livewire — satu
sumber kebenaran logic, banyak entry point.

## Observability & Realtime

Keputusan lengkap → `docs/00-status.md` #13. Semua paket resmi Laravel, open-source, gratis.

| Paket | Status | Untuk apa |
|---|---|---|
| **Pulse** | Dipakai | Dashboard monitoring: query lambat, job gagal, exception rate, di production. Setup sekali di Fase 1, jalan pasif setelahnya. |
| **Telescope** | Dipakai, **local/staging only** | Debug request/query/job detail selama development. **Jangan aktif di production** tanpa gating akses ketat — request log Telescope bisa memuat data lintas-tenant kalau tidak dibatasi siapa yang boleh lihat. |
| **Reverb** | Dipakai | WebSocket server (gratis, alternatif self-hosted dari Pusher/Ably yang berbayar) untuk Notification Center (`docs/02-modules.md` fitur lintas-modul), live update Dashboard, sinkronisasi stok real-time antar sesi kasir. Broadcast channel **wajib di-scope tenant** (`docs/08-tenancy.md`) — tidak boleh ada channel global yang bisa didengar semua tenant. Butuh proses long-running terpisah dari PHP-FPM → pertimbangan hosting (`CLAUDE.md` § Belum diputuskan). |
| **Octane** | **Ditunda** | Bukan soal biaya — risiko arsitektur. Octane menjaga aplikasi tetap di memory antar-request untuk performa, tapi tenancy kita pakai singleton `TenantContext` (`docs/08-tenancy.md`) yang wajib direset tiap request. Kalau lupa direset di bawah Octane: kebocoran data antar-tenant. Baru dipertimbangkan lagi setelah k6 (`docs/05-coding-standards.md` § 4c) buktikan ada bottleneck performa nyata — dan kalau dipakai, wajib audit ulang SEMUA singleton/static state (bukan cuma TenantContext) sebelum go-live. |

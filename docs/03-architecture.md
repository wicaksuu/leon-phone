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
├── Resources/          ← API resource transformer
├── Rules/               ← validation rule custom
├── Services/             ← orkestrasi Actions, tempat DB::transaction() dipanggil
└── Traits/
```

**Aturan penempatan logic**: Controller/Livewire component **memanggil**
Service atau Action, tidak pernah menulis query/business rule langsung. Ini yang membuat
logic bisa dites tanpa HTTP layer dan bisa dipakai ulang lintas entry point (Blade View, POS
Livewire, API webhook marketplace).

## Pilihan Teknis: Blade Static vs Livewire Component

Seluruh UI dibangun menggunakan **Tailwind CSS 4 + DaisyUI 5** dengan tata letak modular (Drawer-based layout terinspirasi dari [DaisyUI Nexus Dashboard Growth](https://nexus.daisyui.com/dashboards/growth)). Pemilihan teknologi halaman ditentukan berdasarkan interaktivitas:

| Kriteria | Blade View (Static/Simple) | Livewire Component |
|---|---|---|
| CRUD standar (Form edit/create sederhana, table non-realtime) | ✅ | |
| Setup awal / Konfigurasi statis | ✅ | |
| Approval workflow (list + detail + tombol approve/reject sederhana) | ✅ | |
| Tampilan Laporan statis (chart statis, export data) | ✅ | |
| Butuh scan-scan berturut cepat (barcode/IMEI/Serial Number) dengan feedback instan | | ✅ |
| Alur linear ketat dengan validasi hard-stop (Packing Station) | | ✅ |
| Layar kasir dengan keyboard shortcut, split payment, real-time calculation | | ✅ |
| Real-time dashboard widgets (counters, live feed) | | ✅ |

Modul yang **sebagian besar menggunakan Blade View**: Master Data (CRUD dasar), Purchasing (management PO), Finance, Akuntansi (COA, Jurnal), HR (kelola user/karyawan), Setting.

Modul yang **sebagian besar menggunakan Livewire Component**: POS Kasir, Packing Station, Layar scan serial unit saat Barang Masuk (Receive) dan Stock Opname, serta Dashboard interaktif.

Modul campuran: Order Management (list order menggunakan Blade view, tapi halaman detail/aksi cepat seperti picking menggunakan Livewire); Marketplace (konfigurasi & log = Blade view, webhook ingestion = job/queue).

## Marketplace Engine

Every marketplace has its own adapter implementing a single interface contract
(`MarketplaceAdapterInterface`): `fetchOrders()`, `pushStock()`, `updateOrderStatus()`, etc.
The engine does not know the details of Shopee vs Tokopedia — it only calls that interface
and processes the results into a uniform `Order` record. Adding a new marketplace = adding
a new adapter implementation, without touching existing Order Management code.

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
`routes/api.php`, memanggil Service yang sama dengan yang dipakai Blade/Livewire — satu
sumber kebenaran logic, banyak entry point.

## Observability & Realtime

Keputusan lengkap → `docs/00-status.md` #13. Semua paket resmi Laravel, open-source, gratis.

| Paket | Status | Untuk apa |
|---|---|---|
| **Pulse** | Dipakai | Dashboard monitoring: query lambat, job gagal, exception rate, di production. Setup sekali di Fase 1, jalan pasif setelahnya. |
| **Telescope** | Dipakai, **local/staging only** | Debug request/query/job detail selama development. **Jangan aktif di production** tanpa gating akses ketat — request log Telescope bisa memuat data lintas-tenant kalau tidak dibatasi siapa yang boleh lihat. |
| **Reverb** | Dipakai | WebSocket server (gratis, alternatif self-hosted dari Pusher/Ably yang berbayar) untuk Notification Center (`docs/02-modules.md` fitur lintas-modul), live update Dashboard, sinkronisasi stok real-time antar sesi kasir. Broadcast channel **wajib di-scope tenant** (`docs/08-tenancy.md`) — tidak boleh ada channel global yang bisa didengar semua tenant. Butuh proses long-running terpisah dari PHP-FPM → pertimbangan hosting (`CLAUDE.md` § Belum diputuskan). |
| **Octane** | **Ditunda** | Bukan soal biaya — risiko arsitektur. Octane menjaga aplikasi tetap di memory antar-request untuk performa, tapi tenancy kita pakai singleton `TenantContext` (`docs/08-tenancy.md`) yang wajib direset tiap request. Kalau lupa direset di bawah Octane: kebocoran data antar-tenant. Baru dipertimbangkan lagi setelah k6 (`docs/05-coding-standards.md` § 4c) buktikan ada bottleneck performa nyata — dan kalau dipakai, wajib audit ulang SEMUA singleton/static state (bukan cuma TenantContext) sebelum go-live. |

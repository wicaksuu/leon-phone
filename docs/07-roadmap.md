# 07 — Roadmap

Lima fase. **Jangan mulai fase berikutnya sebelum fase sebelumnya stabil** — urutan ini
dirancang supaya tidak ada perubahan arsitektur besar di tengah jalan (mis. struktur IMEI
histori harus benar sejak Fase 1 karena semua modul lain bergantung padanya).

> **Testing trio wajib mulai Fase 1**, bukan ditambahkan belakangan (`docs/05-coding-standards.md`
> § 4) — CI Fase 1 sudah harus jalankan Unit + Feature test tiap PR, k6 minimal ada
> skeleton-nya meski baru dipakai serius mulai Fase 2 (belum ada endpoint frekuensi tinggi
> di Fase 1).

## Fase 1 — Fondasi
- Setup project Laravel versi terbaru + MySQL 8.0 + Filament + konvensi `Modules/*`
- **Tenancy** (`docs/08-tenancy.md`): tabel `tenants`/`branches`/`tenant_user`, trait
  `BelongsToTenant` + global scope, Filament native Tenancy dikonfigurasi. Ini FONDASI —
  semua modul berikutnya bergantung pada ini benar sejak awal (menambah tenant scoping
  belakangan ke tabel yang sudah berisi data jauh lebih berisiko daripada dari awal).
- Autentikasi, Role & Permission **per-tenant** (dasar untuk approval workflow di
  fase-fase berikutnya)
- Master Data lengkap (Brand, Kategori, Produk, Varian, Cabang, Gudang, Supplier,
  Customer, Karyawan, Metode Pembayaran)
- Base `DomainException`, Handler mapping, Audit Log observer generik
- CI: Pint + Larastan + PHPUnit (Unit+Feature) + skeleton k6 + test suite dasar

## Fase 2 — Operasional Inti
- Inventory (Barang Masuk, Stock per gudang/rak, Mutasi, Stock Opname)
- IMEI Management penuh (entitas + histori append-only)
- Purchasing (PR → PO → Receive → Invoice → Payment)
- POS Kasir (custom Livewire)
- k6 mulai serius dipakai di sini: aksi checkout POS & scan IMEI adalah kandidat pertama
  (`docs/05-coding-standards.md` § 4c)

→ **Sistem sudah bisa dipakai jualan offline sejak akhir fase ini.**

## Fase 3 — Omnichannel
- Marketplace Engine + adapter marketplace prioritas pertama (ditentukan user)
- Order Management (struktur status penuh, satu struktur untuk semua channel)
- Packing Station (custom Livewire, validasi IMEI hard-stop di Service, bukan cuma di UI)
- Sinkronisasi stok ke marketplace

## Fase 4 — Purnajual
- Return (Marketplace/Offline/DOA, berbasis IMEI)
- Garansi (Waiting → Checking → Claim Vendor → Repair → Done)
- Service (servis umum, sparepart, teknisi)
- CRM (histori pembelian/garansi, point, voucher, broadcast WA)

## Fase 5 — Manajemen
- Finance (Kas, Bank, Hutang/Piutang, Cash Flow)
- **Akuntansi** (`docs/02-modules.md` §18): Chart of Accounts, Jurnal (manual + auto dari
  transaksi modul lain), General Ledger, Saldo Awal, Manajemen Periode (Ganti/Tutup
  Periode, Buka Kunci Data via Approval Workflow, Validasi Data)
- Dashboard analitik penuh
- Report lengkap (semua 12 jenis laporan di `02-modules.md`, plus Neraca/Laba-Rugi/Arus
  Kas yang bersumber dari Akuntansi)
- Approval Workflow matang di semua modul yang butuh (kalau di fase sebelumnya baru versi
  minimal)
- Backup & Restore, Import/Export Excel penuh di semua master data

## Belum masuk fase manapun (tentukan nanti sesuai kebutuhan)
- Aplikasi mobile untuk staf gudang (opsional, API layer sudah disiapkan sejak Fase 1 agar
  ini tinggal tambahan, bukan rombak)
- Multi-marketplace lanjutan di luar 5 yang disebut (Fase 3 hanya prioritas pertama)
- Panel platform admin (kelola daftar tenant/PT di level SaaS, `docs/08-tenancy.md` §
  Platform admin) — belum ditentukan masuk fase mana, kemungkinan paralel dengan Fase 1
  kalau onboarding PT baru harus manual dulu sebelum panel itu ada

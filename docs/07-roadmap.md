# 07 — Roadmap

Lima fase. **Jangan mulai fase berikutnya sebelum fase sebelumnya stabil** — urutan ini
dirancang supaya tidak ada perubahan arsitektur besar di tengah jalan (mis. struktur serial
unit/IMEI histori harus benar sejak Fase 1 karena semua modul lain bergantung padanya).

> **Pivot** (`docs/00-status.md` #26): nama modul & cakupan fitur di roadmap ini sekarang
> mengikuti struktur SISCOM penuh (`02-modules.md`) — replikasi fitur, bukan versi
> simplifikasi. Urutan fase TIDAK berubah (masih fondasi → operasional inti → omnichannel
> → purnajual → manajemen), tapi isi tiap fase diperluas supaya AI agent tidak perlu
> menebak field/flow yang hilang.

> **Testing trio wajib mulai Fase 1**, bukan ditambahkan belakangan (`docs/05-coding-standards.md`
> § 4) — CI Fase 1 sudah harus jalankan Unit + Feature test tiap PR, k6 minimal ada
> skeleton-nya meski baru dipakai serius mulai Fase 2 (belum ada endpoint frekuensi tinggi
> di Fase 1).

## Fase 1 — Fondasi
- Setup project Laravel versi terbaru + MySQL 8.0 + Tailwind CSS 4 + DaisyUI 5 + Laravel Breeze + konvensi `Modules/*`
- **Tenancy** (`docs/08-tenancy.md`): tabel `tenants`/`branches`/`tenant_user`, trait
  `BelongsToTenant` + global scope, custom session-based tenant context + middleware
  `ResolveTenantContext` + dropdown tenant switcher di header/navbar. Ini FONDASI —
  semua modul berikutnya bergantung pada ini benar sejak awal.
- Autentikasi, Role & Permission **per-tenant**, **Setting Menu User** (akses granular
  per-menu individual, `02-modules.md` §6) — dasar untuk approval workflow di fase
  berikutnya.
- Master Data Persediaan lengkap: Master Barang (+ Multi Satuan, flag Tracking/POS/
  Perolehan Poin), Kelompok Barang (hierarkis + Kode Pajak), Brand, Satuan, Ukuran,
  Kelompok Std Harga Jual, Master Gudang (+ Otorisasi per-gudang), Supplier (+ NPWP/
  Limit Hutang), Customer (+ Limit/Kelompok Harga), Kelompok Supplier/Pelanggan,
  Salesman, Karyawan, Tipe Bayar (+ 5 mapping akun), Bank.
- Setting Cabang (+ NPWP level cabang), Cost Centre.
- Base `DomainException`, Handler mapping, Audit Log observer generik (+ Log IP).
- CI: Pint + Larastan + PHPUnit (Unit+Feature) + skeleton k6 + test suite dasar

## Fase 2 — Operasional Inti
- Persediaan transaksi: Stock per gudang/rak, Transfer Gudang, Transfer Sementara
  (reversible), Stock Opname, Penyesuaian Persediaan (+ listimei per-unit)
- Serial Number Management penuh (entitas + histori append-only) — SISCOM tidak
  membedakan tipe IMEI vs Serial Number, cuma 1 flag "Tracking" (`docs/00-status.md` #20)
- Pembelian: PQ → PO (+ status Tutup/partial) → RO/Receive (independen dari Invoice,
  3-way matching) → PI/Faktur Pembelian → Retur Pembelian (wajib Berdasarkan)
- POS Kasir (custom Livewire) — tambahan Leon Phone, bukan dari SISCOM
- k6 mulai serius dipakai di sini: aksi checkout POS & scan serial unit adalah kandidat
  pertama (`docs/05-coding-standards.md` § 4c)

→ **Sistem sudah bisa dipakai jualan offline sejak akhir fase ini.**

## Fase 3 — Omnichannel
- Marketplace Engine + adapter marketplace prioritas pertama (ditentukan user) —
  tambahan Leon Phone
- Penjualan: SQ/Penawaran → SO (+ Pilih SQ, Discount/PPN/Ongkos/Netto, status Tutup) →
  DO/Delivery Order (**scan serial unit terjadi di sini**, bukan di Invoice) → SI/Faktur
  Penjualan → Retur Penjualan (wajib Berdasarkan + Pilih Faktur SI)
- Packing Station (custom Livewire, validasi serial unit hard-stop di Service — selaras
  dgn temuan `listimei` SISCOM di tahap DO)
- Sinkronisasi stok ke marketplace
- E-Faktur — **perlu konfirmasi user dulu**: apakah Leon Phone PKP dan wajib e-Faktur?

## Fase 4 — Purnajual
- Return (Marketplace/Offline/DOA, berbasis serial unit/IMEI) — tambahan Leon Phone di
  luar Retur Pembelian/Penjualan SISCOM
- Garansi (Waiting → Checking → Claim Vendor → Repair → Done)
- Service (servis umum, sparepart, teknisi)
- CRM (histori pembelian/garansi, point loyalty — termasuk flag Perolehan Poin per-produk
  dari Master Barang, voucher, broadcast WA)
- Promo (master data promosi SISCOM, kalau relevan untuk operasional Leon Phone)

## Fase 5 — Manajemen
- Keuangan: AP/AR Down Payment, AP Payment/AR Receipt (+ integrasi Giro langsung di
  form), Cash/Bank Payment/Receipt (multi-baris split akun), Transaksi Bank, Cheque/Giro
  lifecycle (Tolak/Batal/jatuh tempo) — **perlu konfirmasi user**: apakah Leon Phone
  pakai giro?
- **Akunting** (`docs/02-modules.md` §5): COA hierarkis 6-segmen + Cost Centre wajib +
  Anggaran/Thn, Jurnal Manual (validasi real-time debit=kredit) + Jurnal otomatis dari
  transaksi modul lain, General Ledger (view otomatis, tanpa create manual), Aktiva
  Tetap/Fixed Assets (depresiasi otomatis terjadwal), Recurring, Saldo Awal (4 kategori:
  Persediaan/Hutang/Piutang/Neraca), Tutup Periode (bulanan) + Tutup Buku (tahunan,
  terpisah), Buka Kunci Data via Approval Workflow, Validasi Data
- Group Cabang (hierarki tambahan di atas Cabang, kalau dibutuhkan untuk laporan
  konsolidasi regional)
- Dashboard analitik penuh
- Report lengkap (semua laporan `02-modules.md`, plus Neraca/Laba-Rugi/Arus Kas/
  Perubahan Modal dari Akunting, Laporan Umur Hutang/Piutang/Aging, laporan Fast/Slow/
  Dead Moving)
- Approval Workflow matang di semua modul yang butuh
- Backup & Restore, Import/Export Excel penuh di semua master data
- Cetak Barcode dengan template custom (ukuran kertas, posisi baris)
- Perakitan/Assembly (Bahan Baku → Barang Jadi) — kalau relevan, prioritas rendah untuk
  retail HP

## Belum masuk fase manapun (tentukan nanti sesuai kebutuhan)
- Aplikasi mobile untuk staf gudang (opsional, API layer sudah disiapkan sejak Fase 1 agar
  ini tinggal tambahan, bukan rombak)
- Multi-marketplace lanjutan di luar 5 yang disebut (Fase 3 hanya prioritas pertama)
- Panel platform admin (kelola daftar tenant/PT di level SaaS, `docs/08-tenancy.md` §
  Platform admin) — belum ditentukan masuk fase mana, kemungkinan paralel dengan Fase 1
  kalau onboarding PT baru harus manual dulu sebelum panel itu ada

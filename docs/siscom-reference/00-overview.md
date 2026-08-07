# SISCOM ERP — Audit Reference (untuk AI coding agent)

> **⚠️ CAKUPAN JUJUR (baca dulu sebelum asumsi "lengkap")**: kolom LISTING (tabel) di ~82
> halaman 100% tercover. Field FORM "Tambah Data" (create) 100% tercover untuk **semua 42
> URL yang berhasil diidentifikasi** (`03-add-form-fields.md`). Form **EDIT: 21 dari 82
> halaman** berhasil diverifikasi dgn data REAL (`04-edit-form-fields.md`) — sisanya
> **BUKAN gap metode, tapi TERKONFIRMASI KOSONG**: tenant "leon" baru pakai Faktur
> Penjualan (SI) + Faktur Pembelian (PI) + master data dasar, belum pernah menyentuh alur
> Quote→Order→Delivery (SQ/SO/DO/PQ/PO/RO/PR), AP/AR down payment, cash/bank/giro, jurnal
> manual, atau stock opname/adjust/transfer — dicek satu-satu via submit form filter
> (termasuk `coaListing`/Kode Perkiraan, dicek 2x lipat dgn klik LANGSUNG tombol Cari di
> halaman live, bukan cuma reconstruction — modul Akunting memang belum dikonfigurasi
> tenant ini), semua hasilnya 0 baris data. Halaman "murni form aksi" (~21 halaman
> non-listing, mis. `changePeriod`, `eFakturForm`) juga belum di-audit detail fieldnya —
> lihat `docs/00-status.md` #21-25 untuk kronologi.
>
> **Metode**: bukan klik manual — fetch HTML mentah tiap URL menu (`fetch(url,
> {credentials:'include'})` dari dalam browser yang sudah login user), parse via
> `DOMParser`, ambil SEMUA header kolom tabel (termasuk yang tersembunyi dari tampilan
> default) + field form + opsi dropdown. Cuma baca (GET), tidak pernah submit/klik
> Actions (edit/hapus/lock) — lihat `docs/00-status.md` #20-21 untuk batasan lengkap.
>
> **Cakupan LISTING**: SEMUA menu sampai level sub-submenu (82 halaman unik: Dashboard,
> Persediaan, Pembelian, Penjualan, Keuangan, Akunting, Utiliti, Saldo Awal, Help/Tools).
> Halaman "Laporan *" (murni report/view) TIDAK di-fetch detail satu-satu — kebanyakan
> cuma nampilkan form filter kosong (`Cabang/Harga Jual/Sumber`) sebelum submit.
>
> Tenant yang diaudit: **leon** (LEON SELLULAR INDONESIA) — jual HP asli (Realme, Xiaomi,
> Infinix, Apple). Vendor SISCOM: PT. Shan Informasi Sistem.

## Cara pakai dokumen ini

1. `01-field-inventory.md` — inventaris LENGKAP semua field per halaman/modul, hasil raw
   extraction. Ini sumber kebenaran mentah (tabel ringkas, bukan HTML mentah).
2. `02-gap-analysis.md` — perbandingan eksplisit field SISCOM vs desain kita
   (`docs/02-modules.md` + `docs/04-database.md`), per modul, status ✅/⚠️/❌. Basisnya
   masih kolom LISTING — belum termasuk temuan tambahan dari form Tambah (lihat #3).
3. `03-add-form-fields.md` — field form "Tambah Data" (create), 42/42 URL teridentifikasi
   sudah diverifikasi. Ada juga peringatan soal bug copy-paste di kode SISCOM sendiri
   (10 halaman transaksi "Tambah"-nya sempat nyasar ke `addPo` via `otorisasiAdd()`,
   sudah diresolve via URL pengganti terverifikasi).
4. `04-edit-form-fields.md` — field form "Edit" (ubah data), 21/82 halaman terverifikasi
   + daftar lengkap modul yang terkonfirmasi kosong (bukan gagal diaudit).
5. `html/` — **HTML mentah 143 halaman** (82 listing + 42 add-form + 21 edit-form, hasil
   `fetch()` langsung, sebelum di-parse).
   **TIDAK di-commit ke git** (lihat `.gitignore` — isu hak cipta/ToS aplikasi pihak
   ketiga + ukuran ~14MB), tersimpan LOKAL saja di mesin ini. Nama file: `siscom_
   {slug-url}.html` (mis. `siscom_goodsListing.html`). Buka file ini kalau butuh detail
   struktur yang tidak tertangkap ringkasan `01-field-inventory.md` (mis. urutan visual
   form, class CSS, JS inline). Kalau sesi berikutnya jalan di MESIN LAIN, folder ini
   tidak akan ada — cuma sumber kebenaran mentahnya `01-field-inventory.md`.
6. Field generik `Doe/Toe/Loe/Deo/Actions` yang muncul di HAMPIR SEMUA tabel SISCOM
   **sengaja tidak dicatat berulang** di `01-field-inventory.md` — itu kolom audit-trail
   generik bawaan framework SISCOM (kemungkinan: Date-of-entry/Time-of-entry/Log-of-entry/
   Date-of-edit), setara `created_at`/`updated_at`/`created_by` kita, bukan field bisnis.

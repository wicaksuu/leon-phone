# SISCOM ERP — Audit Reference (untuk AI coding agent)

> **⚠️ CAKUPAN JUJUR (baca dulu sebelum asumsi "lengkap")**: yang 100% tercover cuma
> kolom LISTING (tabel) di ~82 halaman. Field FORM "Tambah Data" (create) baru tercover
> untuk **13 dari 42 halaman yang teridentifikasi** (`03-add-form-fields.md`), dan form
> EDIT cuma 1 dari 82 halaman yang pernah dibuka. **JANGAN anggap dokumen ini gambaran
> lengkap 100%** — lihat `docs/00-status.md` #21 untuk kronologi kenapa (#20 sempat
> mengklaim "SELESAI" secara prematur, dikoreksi setelah user tanya eksplisit).
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
3. `03-add-form-fields.md` — field form "Tambah Data" (create), BARU 13 dari 42 halaman.
   Ada juga daftar eksplisit halaman mana yang URL Tambah-nya belum ketemu, dan
   peringatan soal kemungkinan bug copy-paste di kode SISCOM sendiri (10 halaman transaksi
   semua "Tambah"-nya nyasar ke `addPo`).
4. `html/` — **HTML mentah 82 halaman** (hasil `fetch()` langsung, sebelum di-parse).
   **TIDAK di-commit ke git** (lihat `.gitignore` — isu hak cipta/ToS aplikasi pihak
   ketiga + ukuran ~14MB), tersimpan LOKAL saja di mesin ini. Nama file: `siscom_
   {slug-url}.html` (mis. `siscom_goodsListing.html`). Buka file ini kalau butuh detail
   struktur yang tidak tertangkap ringkasan `01-field-inventory.md` (mis. urutan visual
   form, class CSS, JS inline). Kalau sesi berikutnya jalan di MESIN LAIN, folder ini
   tidak akan ada — cuma sumber kebenaran mentahnya `01-field-inventory.md`.
5. Field generik `Doe/Toe/Loe/Deo/Actions` yang muncul di HAMPIR SEMUA tabel SISCOM
   **sengaja tidak dicatat berulang** di `01-field-inventory.md` — itu kolom audit-trail
   generik bawaan framework SISCOM (kemungkinan: Date-of-entry/Time-of-entry/Log-of-entry/
   Date-of-edit), setara `created_at`/`updated_at`/`created_by` kita, bukan field bisnis.

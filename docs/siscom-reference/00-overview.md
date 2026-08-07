# SISCOM ERP — Audit Reference (untuk AI coding agent)

> **Metode**: bukan klik manual — fetch HTML mentah tiap URL menu (`fetch(url,
> {credentials:'include'})` dari dalam browser yang sudah login user), parse via
> `DOMParser`, ambil SEMUA header kolom tabel (termasuk yang tersembunyi dari tampilan
> default) + field form + opsi dropdown. Cuma baca (GET), tidak pernah submit/klik
> Actions (edit/hapus/lock) — lihat `docs/00-status.md` #20 untuk batasan lengkap.
>
> **Cakupan**: SEMUA menu sampai level sub-submenu (~100 halaman: Dashboard, Persediaan,
> Pembelian, Penjualan, Keuangan, Akunting, Utiliti, Saldo Awal, Help/Tools). Halaman
> "Laporan *" (murni report/view) TIDAK di-fetch detail satu-satu — kebanyakan cuma
> nampilkan form filter kosong (`Cabang/Harga Jual/Sumber`) sebelum submit, jadi tidak
> banyak info baru dibanding listing utamanya yang sudah diaudit.
>
> Tenant yang diaudit: **leon** (LEON SELLULAR INDONESIA) — jual HP asli (Realme, Xiaomi,
> Infinix, Apple). Vendor SISCOM: PT. Shan Informasi Sistem.

## Cara pakai dokumen ini

1. `01-field-inventory.md` — inventaris LENGKAP semua field per halaman/modul, hasil raw
   extraction. Ini sumber kebenaran mentah (tabel ringkas, bukan HTML mentah).
2. `02-gap-analysis.md` — perbandingan eksplisit field SISCOM vs desain kita
   (`docs/02-modules.md` + `docs/04-database.md`), per modul, status ✅/⚠️/❌. **Baca ini
   duluan** kalau mau tahu ringkasan "sudah 100% sama atau belum" — itu jawabannya: BELUM,
   dan gap-nya didaftar eksplisit.
3. `html/` — **HTML mentah 82 halaman** (hasil `fetch()` langsung, sebelum di-parse).
   **TIDAK di-commit ke git** (lihat `.gitignore` — isu hak cipta/ToS aplikasi pihak
   ketiga + ukuran ~14MB), tersimpan LOKAL saja di mesin ini. Nama file: `siscom_
   {slug-url}.html` (mis. `siscom_goodsListing.html`). Buka file ini kalau butuh detail
   struktur yang tidak tertangkap ringkasan `01-field-inventory.md` (mis. urutan visual
   form, class CSS, JS inline). Kalau sesi berikutnya jalan di MESIN LAIN, folder ini
   tidak akan ada — cuma sumber kebenaran mentahnya `01-field-inventory.md`.
4. Field generik `Doe/Toe/Loe/Deo/Actions` yang muncul di HAMPIR SEMUA tabel SISCOM
   **sengaja tidak dicatat berulang** di `01-field-inventory.md` — itu kolom audit-trail
   generik bawaan framework SISCOM (kemungkinan: Date-of-entry/Time-of-entry/Log-of-entry/
   Date-of-edit), setara `created_at`/`updated_at`/`created_by` kita, bukan field bisnis.

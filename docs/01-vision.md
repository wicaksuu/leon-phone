# 01 — Vision

## RMS, bukan POS

POS (Point of Sale) hanya menjawab satu pertanyaan: "bagaimana transaksi di kasir dicatat?".
Toko HP & elektronik butuh jauh lebih banyak dari itu: dari mana barang datang
(purchasing), berapa persisnya stok di tiap lokasi (inventory), unit dengan
IMEI/Serial Number tertentu sekarang ada di mana (tracking per-unit — lihat
`docs/00-status.md` #18, bukan cuma IMEI/HP), bagaimana order dari 5 marketplace berbeda
diproses seragam (omnichannel), apa yang terjadi kalau barang rusak/diretur (purnajual),
dan seberapa untung sebenarnya bisnis ini (finance & report).

Maka sistem ini disebut **Retail Management System**. POS Kasir adalah satu modul di
dalamnya, bukan pusatnya.

## Multi-tenant SaaS (bukan single-tenant lagi — lihat `docs/00-status.md` #3)

> Bagian ini pernah berjudul "Single-tenant, dan itu keputusan sadar". Draf paling awal
> proyek mengasumsikan satu perusahaan/toko saja. Setelah user klarifikasi bahwa sistem
> ini memang untuk **banyak PT** (nama proyek sendiri "SAAS POS LEON PHONE"), keputusan
> itu dibalik. Riwayatnya sengaja disimpan di sini + `docs/00-status.md` supaya jejak
> perubahan arah tetap kelihatan.

Sistem ini dipakai oleh **banyak PT** (perusahaan/toko retail HP) sekaligus, satu
instalasi untuk semua. Konsekuensi desain:

- **Setiap tabel bisnis punya kolom `tenant_id`**, dan setiap query WAJIB ter-scope oleh
  itu — tidak ada pengecualian. Mekanisme wajib (trait + global scope + Filament tenancy)
  ada di `docs/08-tenancy.md`, bukan sesuatu yang diimplementasi ad-hoc per modul.
- Isolasi data pakai **shared database**, bukan database terpisah per PT — satu MySQL 8.0,
  semua PT, dipisahkan lewat `tenant_id`. (Ini beda dari referensi visual SISCOM yang
  dipakai sebagai acuan struktur menu — SISCOM pakai database terpisah per PT. Kita
  sengaja tidak ikut pola itu karena lebih sederhana dioperasikan untuk skala saat ini.)
- Hierarki di dalam satu PT: **PT → Cabang → Gudang**. Satu user bisa punya akses ke lebih
  dari satu PT dan memilih PT aktif setelah login (tenant switcher).
- Kompleksitas tenancy ini **tidak menghapus** kompleksitas operasional yang sudah jadi
  fokus dari awal: histori unit (IMEI/Serial Number) yang tidak boleh bolong, stok yang
  tidak boleh minus tanpa sebab, setiap perubahan uang/stok yang bisa diaudit — itu semua
  tetap berlaku, sekarang tinggal ditambah satu dimensi lagi (per-tenant).

## Siapa pemakainya

- **Kasir** — POS Kasir, transaksi harian, scan barcode/IMEI/Serial Number, split payment.
- **Admin gudang** — Packing Station, stock opname, mutasi antar gudang, receive barang.
- **Purchasing/owner** — Purchase Order, supplier, laporan margin.
- **CS/Marketplace admin** — pantau order masuk dari semua marketplace di satu tempat.
- **Teknisi servis** — modul Service, klaim garansi vendor.
- **Owner/manajemen** — Dashboard, Report, Finance, Akuntansi, approval workflow.
- **Akuntan** — Jurnal, Chart of Accounts, Saldo Awal, tutup periode.
- **Platform admin (level SaaS)** — role di luar konteks satu PT: kelola daftar tenant/PT,
  aktivasi/nonaktifasi langganan. Detail wewenang & scope role ini → `docs/08-tenancy.md`.

## Prinsip yang memandu semua keputusan desain berikutnya

1. **Kebenaran data > kecepatan development.** Lebih baik operasi gagal total dengan pesan
   jelas daripada berhasil sebagian dan stok/uang jadi tidak sinkron.
2. **Unit fisik (IMEI/Serial Number) adalah sumber kebenaran.** Kalau data sistem dan
   barang fisik tidak cocok, sistem yang salah, bukan barangnya. (Digeneralisasi dari
   "IMEI" murni — lihat `docs/00-status.md` #18: bukan cuma HP, elektronik lain pakai
   Serial Number.)
3. **Semua channel penjualan (offline + marketplace) melewati struktur order yang sama.**
   Tidak ada jalur pintas per-marketplace yang bikin data order jadi tidak seragam.
4. **Setiap perubahan penting bisa dijawab: siapa, kapan, kenapa.** (Audit log + approval
   workflow bukan fitur tambahan, tapi bagian dari cara kerja normal.)

# LEON PHONE — Retail Management System (RMS)

> **Status: BLUEPRINT ONLY.** Belum ada kode. Direktori ini baru berisi dokumen arah & struktur.
> Jangan mulai coding tanpa membaca dokumen ini + `docs/` terkait dulu.
>
> **BACA `docs/00-status.md` DULUAN, SEBELUM DOKUMEN LAIN.** Itu log keputusan +
> status terkini proyek. User bisa berhenti kapan saja lalu lanjut hari lain — dokumen
> itu yang memastikan sesi AI berikutnya (fresh, tanpa histori chat sebelumnya) tidak
> mengulang pertanyaan yang sudah dijawab atau lupa keputusan yang sudah diambil.
> **Setiap kali ada keputusan baru/perubahan arah, update `docs/00-status.md` juga**,
> bukan cuma dokumen teknisnya.

## Apa ini

Sistem **multi-tenant SaaS**: satu instalasi melayani **banyak PT** (perusahaan/toko retail
HP & elektronik — lihat `docs/00-status.md` #18, bukan cuma HP) sekaligus. Satu user bisa
punya akses ke lebih dari satu PT dan memilih PT aktif setelah login (lihat referensi UI di
`ref-gambar/`, dibedah di `docs/08-tenancy.md`). Ini bukan sekadar "POS" — POS Kasir hanya
salah satu modul. Sistem ini adalah **Retail Management System**: inventory + tracking unit
per-IMEI/Serial Number + omnichannel marketplace + purchasing + finance + akuntansi +
purnajual (retur/garansi/servis) + CRM, dengan POS Kasir & Packing Station sebagai titik
operasional harian.

Isolasi antar PT memakai pola **shared database + kolom `tenant_id`** (bukan database
terpisah per PT) — satu database MySQL 8.0, semua tabel bisnis di-scope otomatis per tenant.
Detail lengkap → `docs/08-tenancy.md`.

Hierarki lokasi di dalam satu PT: **PT → Cabang → Gudang** (satu Cabang bisa punya banyak
Gudang). Lihat `docs/04-database.md`.

> **Catatan riwayat**: draf paling awal proyek ini sempat mengasumsikan single-tenant (satu
> PT saja, lihat `docs/01-vision.md`). Itu **sudah tidak berlaku** — keputusan final adalah
> multi-tenant SaaS seperti di atas, dikonfirmasi setelah melihat referensi produk sejenis
> (SISCOM ERP, screenshot di `ref-gambar/`).

## Tech stack (keputusan final, jangan diganti tanpa diskusi)

| Layer | Pilihan | Alasan |
|---|---|---|
| Backend | **Laravel versi terbaru** (bukan LTS lama — pakai rilis terbaru saat mulai coding) | Ekosistem modular matang, cocok untuk domain-driven structure |
| Database | **MySQL 8.0** (bukan MariaDB — dibalik saat instalasi, lihat `docs/00-status.md` #14) | Sudah jalan lokal di mesin dev user, alasan praktis, driver Laravel sama (`mysql`) |
| Multi-tenancy | **Shared DB + `tenant_id`**, via custom session-based middleware | Menyimpan context tenant aktif di session (`session('tenant_id')`) dan di-resolve oleh middleware `ResolveTenantContext` menjadi singleton `TenantContext` |
| Autentikasi | **Laravel Breeze** (Blade stack) | Starter kit resmi, ringan, sudah menyertakan Tailwind CSS, view/controller dapat dicustom penuh |
| Layout Utama | **Tailwind-Admin sidebar-based layout** | Mengikuti template [Tailwind-Admin](https://github.com/Tailwind-Admin/free-tailwind-admin-dashboard-template): sidebar kiri collapsible + sticky top header di kanan atas |
| Frontend styling | **Tailwind CSS 4 + Preline UI** | Preline UI menyediakan pustaka komponen siap pakai yang terintegrasi dengan Tailwind CSS 4 + vanilla JS plugin (`preline.js`) untuk interaksi UI modern/responsif |

Detail lengkap tiap keputusan → `docs/03-architecture.md`.

## Peta dokumen

- `docs/00-status.md` — **baca ini duluan**: log keputusan + status terkini, resume point
- `docs/01-vision.md` — kenapa RMS bukan POS, siapa pemakainya (§ single-tenant di dalamnya sudah usang, lihat catatan riwayat di atas)
- `docs/02-modules.md` — daftar & detail modul, terstruktur mengikuti SISCOM langsung
  (Dashboard, Persediaan, Pembelian, Penjualan, Keuangan, Akuntansi, Utiliti, Saldo Awal,
  Help) + modul tambahan Leon Phone (Marketplace, POS Kasir, Packing Station, dll) — lihat
  `docs/00-status.md` #26 kenapa strukturnya diganti dari abstraksi 18-modul lama
- `docs/03-architecture.md` — struktur folder `Modules/*`, konvensi Actions/DTOs/Services, pilihan teknis Blade vs Livewire
- `docs/04-database.md` — konvensi MySQL 8.0, entitas kunci (tenant/PT/Cabang, serial unit lifecycle IMEI/SN, stock states, order status, akuntansi), naming convention
- `docs/05-coding-standards.md` — **wajib dibaca sebelum nulis kode apapun**: error handling, DB transaction/rollback, testing
- `docs/06-ui-ux-guidelines.md` — standar visual modern/premium/responsive, breakpoint, komponen DaisyUI, layout Nexus Dashboard, log referensi visual (`ref-gambar/`)
- `docs/07-roadmap.md` — 5 fase implementasi, urutan build
- `docs/08-tenancy.md` — **model multi-tenant SaaS**: struktur PT/tenant, isolasi data, flow login, pilih PT & custom session switcher

## Referensi visual

Screenshot produk sejenis (SISCOM ERP) ditaruh di `ref-gambar/` sebagai bahan pembanding
struktur menu & komposisi halaman (bukan acuan gaya visual — tampilan tetap didesain baru
mengikuti `docs/06-ui-ux-guidelines.md`). Ini masih **proses bertahap**: user akan menambah
screenshot per-menu ke folder ini secara berkala. Kalau ada file baru muncul di
`ref-gambar/` yang belum dibahas di dokumen manapun, itu artinya blueprint belum sinkron —
periksa isinya dan update dokumen relevan sebelum melanjutkan development di area itu.

Yang sudah masuk sejauh ini:
1. `WhatsApp Image 2026-08-07 at 16.43.08.jpeg` — Dashboard (kartu info perusahaan, feed
   aktivitas/audit log, chart best seller, ringkasan Penjualan/Piutang/Pembelian/Hutang,
   chart Pembayaran Hutang vs Piutang, chart Laba/Rugi). Struktur menu sidebar: Dashboard,
   Persediaan, Pembelian, Penjualan, Keuangan, Akuntansi, Utiliti (Setting Cabang, Setting
   Default, Setting Password, Setting Menu User, Maintenance Data, Ganti Periode, Tutup
   Periode, Buka Kunci Data, Validasi Data), Saldo Awal, Help.
2. `WhatsApp Image 2026-08-07 at 16.47.07.jpeg` — halaman pilih PT setelah login (di
   referensi aslinya per-PT = database terpisah; **di project kita ini jadi dropdown tenant switcher
   custom (DaisyUI dropdown) berbasis session**, bukan pilih database, karena kita pakai shared DB + `tenant_id`).

## Aturan kerja untuk AI agent di project ini

1. **Modular per domain.** Setiap modul bisnis hidup di `Modules/<NamaModul>/` dengan
   sub-folder standar (`Actions/ DTOs/ Enums/ Events/ Exceptions/ Jobs/ Listeners/ Models/
   Observers/ Policies/ Repositories/ Requests/ Resources/ Rules/ Services/ Traits/`).
   Jangan taruh logic bisnis di controller atau di root `app/`.
2. **Setiap operasi yang mengubah data lintas tabel WAJIB dibungkus `DB::transaction()`**
   dan punya rollback path yang jelas. Lihat `docs/05-coding-standards.md`.
3. **Error handling konsisten**: exception khusus per domain (mis. `InsufficientStockException`,
   `DuplicateSerialUnitException`), bukan `throw new Exception('...')` generik. Semua exception
   ditangani di satu tempat (`Handler`) dengan response format seragam (DaisyUI notification/toast
   untuk web/livewire, JSON terstruktur untuk API/marketplace webhook).
4. **Unit ber-identifier (IMEI untuk HP, Serial Number untuk elektronik lain) adalah
   entitas kelas satu**, bukan sekadar kolom — lihat `docs/00-status.md` #18 kenapa ini
   digeneralisasi dari "IMEI" murni. Setiap unit punya histori penuh (supplier → tanggal
   masuk → gudang → marketplace → order → customer → garansi → retur). Barang tanpa
   identifier individual (aksesoris) TIDAK masuk sini, tetap agregat di `stock_items`.
   Lihat `docs/04-database.md`.
5. **UI/UX**: semua layar baru harus modern, premium, dan responsive di semua ukuran layar
   (mobile staf gudang, tablet kasir, desktop admin). Ikuti `docs/06-ui-ux-guidelines.md` —
   jangan improvisasi palet/komponen baru di luar design token yang sudah ditentukan (ikuti styling DaisyUI 5).
6. **Jangan mulai fase berikutnya sebelum fase sebelumnya (lihat roadmap) selesai** —
   urutan ini sengaja dibuat supaya tidak ada perubahan arsitektur besar di tengah jalan.
7. Bahasa komunikasi dengan user: **Bahasa Indonesia**. Nama variabel/class/kode: **Inggris**
   (standar Laravel).
8. **Setiap model/tabel bisnis WAJIB scoped by `tenant_id`.** Tidak ada query yang boleh
   menembus lintas tenant. Lihat `docs/08-tenancy.md` untuk mekanisme wajib (trait +
   global scope + custom session-based `ResolveTenantContext` middleware) — jangan implementasi scoping manual ad-hoc per modul.
9. **Setiap fitur/endpoint baru WAJIB disertai 3 jenis test**: Unit test, Feature/
   Integration test, dan skrip k6 (untuk aksi yang dipanggil frekuensi tinggi seperti
   POS checkout, scan serial unit, sync marketplace). Lihat `docs/05-coding-standards.md` § Testing.
   PR/perubahan tanpa ketiganya dianggap belum selesai.

## Belum diputuskan (tanyakan ke user sebelum asumsi)

- Versi PHP spesifik saat mulai coding (Laravel-nya sudah pasti versi terbaru)
- Hosting/deployment target (VPS, shared hosting, cloud?) — **catatan: karena Reverb
  dipakai (`docs/03-architecture.md` § Observability & Realtime), butuh proses
  long-running terpisah dari PHP-FPM, jadi shared hosting biasa kemungkinan tidak cukup**
- Integrasi marketplace mana yang jadi prioritas pertama (Shopee/Tokopedia/TikTok/dll)
- Payment gateway untuk QRIS/transfer otomatis
- Apakah butuh printer thermal driver khusus atau cukup browser print
- Apakah Leon Phone PKP dan wajib E-Faktur elektronik (fitur ada di SISCOM, relevan
  utk Fase 3 — lihat `docs/07-roadmap.md`)
- Apakah operasional Leon Phone transaksi pakai Cheque/Giro (fitur ada di SISCOM,
  relevan utk Fase 5 — lihat `docs/07-roadmap.md`)
- Pola Approval Workflow: ikut SISCOM (step-up authorization SINKRON — supervisor login
  modal di tempat, transaksi lanjut seketika) atau tetap pola async kita (request→pending
  →approve nanti), atau dukung dua-duanya — lihat
  `docs/siscom-reference/05-business-logic.md` § Pola Approval, `docs/00-status.md` #27

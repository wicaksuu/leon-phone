# 00 — Status & Decision Log

> **Baca file ini paling pertama, sebelum dokumen lain.** Ini bukan dokumen teknis — ini
> log keputusan + status terkini, supaya sesi AI baru (yang tidak punya histori chat
> sebelumnya) bisa langsung tahu di mana proyek berhenti dan kenapa keputusan tertentu
> diambil, tanpa mengulang pertanyaan yang user sudah jawab.

## Status saat ini

**Fase: BLUEPRINT.** Belum ada satu baris kode pun. Yang ada baru dokumen arah & struktur
di `CLAUDE.md` + `docs/*`. Instalasi Laravel belum dimulai — user sengaja minta
"jangan langsung bikin" supaya arah & strukturnya matang dulu.

**Sedang berlangsung**: user mengumpulkan screenshot referensi (produk sejenis: SISCOM
ERP) secara bertahap ke folder `ref-gambar/`, per-menu, untuk jadi acuan struktur & isi
konten (bukan acuan gaya visual). Cek `CLAUDE.md` § Referensi visual untuk daftar yang
sudah masuk vs yang masih ditunggu. **Kalau ada file baru di `ref-gambar/` yang belum
tercatat di log itu, itu artinya dokumen belum sinkron dengan referensi terbaru — proses
dulu sebelum lanjut kerja di area terkait.**

## Log keputusan (kronologis)

Semua tanggal di bawah ini 2026-08-07 (hari yang sama, sesi awal proyek).

1. **RMS, bukan sekadar POS.** User punya spec awal panjang (17 modul: Dashboard, Master
   Data, Inventory, IMEI Management, Marketplace, Order Management, POS Kasir, Packing
   Station, Return, Garansi, Service, CRM, Purchasing, Finance, HR, Report, Setting/User)
   plus fitur lintas-modul (audit log, approval workflow, riwayat harga, barcode/QR,
   import/export, attachment, notification center, backup/restore). Ini jadi basis
   `docs/02-modules.md`.

2. **Database: MariaDB.** Tidak didiskusikan lagi, langsung final.

3. **~~Single-tenant~~ → Multi-tenant SaaS (DIBALIK).** Draf awal spec user berbunyi
   "kalau single tenant, arsitekturnya lebih sederhana..." — sempat diasumsikan itu
   keputusan final dan blueprint pertama (`docs/01-vision.md` versi awal) ditulis
   single-tenant. **User lalu klarifikasi: proyek ini memang untuk banyak PT** (nama
   folder proyek sendiri "SAAS POS LEON PHONE" — SAAS-nya literal). Dikonfirmasi lewat
   referensi visual SISCOM ERP (`ref-gambar/`) yang punya halaman pilih-PT setelah login.
   **Keputusan final**: multi-tenant, **shared database + kolom `tenant_id`** (BUKAN
   database terpisah per PT, meskipun referensi visualnya pakai pola itu — user pilih
   shared DB karena lebih simpel dioperasikan). Detail → `docs/08-tenancy.md`.

4. **Hierarki lokasi: PT → Cabang → Gudang.** Dari referensi SISCOM ("Total Cabang" di
   dashboard). Satu Cabang bisa punya banyak Gudang. Ini levelnya DI ATAS konsep Gudang
   yang sudah ada di spec awal user — bukan pengganti.

5. **Modul tambahan: Akuntansi**, terpisah dari Finance/Keuangan. Dari referensi SISCOM
   (menu "Akuntansi" terpisah dari "Keuangan", plus "Saldo Awal", dan disiplin periode:
   Ganti Periode/Tutup Periode/Buka Kunci Data/Validasi Data). Spec awal user tidak
   menyebut ini eksplisit — ini murni tambahan dari referensi.

6. **Frontend stack: Filament untuk admin, React+Vite+API untuk operasional.** Awalnya
   dipilih Filament untuk SEMUA UI (server-rendered, cepat, modern bawaan). **Lalu user
   minta arsitektur full-API** supaya bisa ada 2 AI agent kerja paralel — satu backend,
   satu frontend — tanpa saling blocking. Filament tidak bisa dipisah ke agent frontend
   (dia render HTML dari sisi Laravel), jadi solusinya **dipecah**:
   - **Filament** tetap dipakai untuk modul CRUD-berat (Master Data, Purchasing, Finance,
     Akuntansi, HR, Report, Setting) → dikerjakan **backend agent**.
   - **REST API (Laravel + Sanctum) + React + Vite** untuk modul operasional/customer-
     facing (POS Kasir, Packing Station, Dashboard, dll) → API-nya ditulis backend agent,
     UI React-nya ditulis **frontend agent** terpisah, kontraknya adalah shape
     request/response API.
   Detail pembagian modul mana masuk sisi mana → `docs/03-architecture.md`.

7. **Laravel versi terbaru** (bukan LTS lama) saat mulai coding — bukan pin ke versi
   spesifik, cek versi terbaru stabil pas development dimulai.

8. **Testing wajib: trio Unit + Feature/Integration + k6.** Setiap fitur/endpoint baru
   harus disertai ketiganya — Unit test (class/method terisolasi), Feature test (endpoint
   API/flow lengkap termasuk transaction & rollback), k6 (load test untuk endpoint
   frekuensi tinggi: POS checkout, scan IMEI, sync marketplace). Detail →
   `docs/05-coding-standards.md` § Testing.

9. **Error handling & DB rollback adalah prioritas eksplisit user**, bukan cuma
   nice-to-have. Setiap operasi lintas-tabel wajib `DB::transaction()`, exception per
   domain (bukan generic `Exception`), satu tempat menangani exception (`Handler`).
   Detail → `docs/05-coding-standards.md`.

10. **UI/UX**: modern, premium, responsive di semua ukuran layar — ini juga prioritas
    eksplisit user, bukan asumsi. Referensi SISCOM dipakai untuk STRUKTUR/KOMPOSISI
    halaman saja (kartu info, feed aktivitas, chart, dll), bukan untuk gaya visualnya
    (SISCOM terlihat dense/klasik ala ERP lama — user eksplisit minta tampilan baru).

11. **graphify sudah dijalankan sekali** terhadap blueprint awal (sebelum pivot
    multi-tenant/API/testing di atas) — hasil di `graphify-out/`. **Graph itu SUDAH USANG**
    sebagian (mencerminkan versi single-tenant, Filament-only). Perlu di-`--update` lagi
    setelah revisi dokumen selesai kalau user minta graph di-refresh.

12. **~~Frontend stack: Filament + React+API 2-agent split~~ → DIBALIK, balik full
    Filament (+ Livewire untuk layar operasional).** Keputusan #6 di atas (Filament untuk
    admin, REST API+React+Sanctum untuk operasional supaya 2 AI agent backend/frontend
    bisa kerja paralel) **dibatalkan** hari yang sama setelah dipikir ulang — user
    mengonfirmasi kembali ke **full Filament** untuk seluruh sistem, drop rencana split
    2 agent. Konsekuensi:
    - Tidak ada React/Vite/Sanctum SPA terpisah. Tidak ada "frontend agent" independen.
    - POS Kasir, Packing Station kembali ke pola awal: **custom Livewire** (bukan Filament
      resource biasa, karena tetap butuh UX real-time scan-first — alasannya sama seperti
      sebelum keputusan #6, cuma implementasinya Livewire lagi, bukan React).
    - REST API (`routes/api.php`) tetap ada tapi perannya kembali sekunder: webhook
      marketplace + opsional app mobile masa depan — BUKAN lagi primary interface yang
      dikonsumsi frontend terpisah.
    - Poin #6 di atas **dibiarkan tercatat apa adanya** (bukan dihapus) supaya jejak
      perubahan arah tetap kelihatan — sama prinsipnya dengan pembalikan single-tenant di
      #3. Kalau nanti user berubah pikiran lagi soal ini, cek dulu riwayat #6 dan #12 di
      sini sebelum tanya ulang dari nol.

13. **Tooling observability/realtime: Pulse + Telescope + Reverb dipakai, Octane
    ditunda.** Semuanya gratis (paket resmi Laravel, open-source, bukan layanan
    berbayar — user sempat khawatir ini berbayar, sudah diklarifikasi tidak). Detail →
    `docs/03-architecture.md` § Observability & Realtime.
    - **Pulse**: dipakai, monitoring query lambat/job/exception di production.
    - **Telescope**: dipakai, tapi **local/staging only** — jangan aktif di production
      tanpa gating ketat (risiko bocor data antar-tenant lewat query/request log kalau
      bisa diakses sembarangan).
    - **Reverb**: dipakai untuk Notification Center, live dashboard, sinkronisasi stok
      real-time. Ini alternatif GRATIS dari Pusher/Ably (yang berbayar) — sengaja dibuat
      Laravel untuk itu. Konsekuensi: butuh proses long-running terpisah dari PHP-FPM →
      **hosting shared biasa kemungkinan tidak cukup, perlu VPS** (nyambung ke item
      "Hosting/deployment target" di `CLAUDE.md` § Belum diputuskan).
    - **Octane**: **ditunda**, bukan soal biaya (gratis juga) tapi risiko arsitektur —
      Octane bikin aplikasi tetap live di memory antar-request, sementara tenancy kita
      pakai singleton `TenantContext` (`docs/08-tenancy.md`) yang wajib di-reset tiap
      request. Kalau lupa reset di bawah Octane, risikonya kebocoran data antar-tenant.
      Baru dipertimbangkan lagi kalau k6 (`docs/05-coding-standards.md` §4c) buktikan ada
      bottleneck performa nyata, bukan dipasang preventif dari awal.

14. **~~Database: MariaDB~~ → DIBALIK, pakai MySQL 8.0.** Keputusan #2 di atas (MariaDB)
    dibalik saat mulai instalasi Laravel: mesin dev lokal user sudah punya **MySQL 8.0**
    jalan sebagai Homebrew service (`mysql@8.0`), sementara MariaDB baru ter-install tapi
    belum aktif. Ditawarkan dua opsi (matikan MySQL & jalankan MariaDB di port 3306, atau
    jalankan MariaDB di port lain berdampingan) — **user pilih pakai MySQL yang sudah
    jalan saja**, murni alasan praktis (hindari utak-atik service, tidak mau ganggu
    project lain yang mungkin masih pakai MySQL service itu). Konsekuensi:
    - `DB_CONNECTION=mysql` di `.env`, bukan konfigurasi MariaDB terpisah — secara
      driver Laravel keduanya sama (`mysql` driver), jadi tidak ada perubahan kode.
    - Semua dokumen yang menyebut "MariaDB" (`CLAUDE.md`, `docs/04-database.md`,
      `docs/08-tenancy.md`, `docs/01-vision.md`, `docs/07-roadmap.md`) diupdate ke
      "MySQL 8.0" mengikuti keputusan ini.
    - Poin #2 di atas dibiarkan tercatat apa adanya (bukan dihapus) — sama prinsipnya
      dengan pembalikan-pembalikan lain di log ini.

## Pending / belum diputuskan

Lihat `CLAUDE.md` § Belum diputuskan untuk daftar lengkap & terbaru — jangan duplikasi di
sini, itu sumber kebenarannya. Ringkasnya: versi PHP spesifik, hosting/deployment target,
prioritas marketplace pertama, payment gateway, printer thermal.

## Cara pakai file ini (untuk AI session berikutnya)

1. Baca file ini dulu untuk tahu histori & keputusan yang sudah diambil — **jangan tanya
   ulang** hal yang statusnya sudah "final" di log di atas.
2. Cek folder `ref-gambar/` — kalau ada file baru yang belum masuk log referensi di
   `docs/06-ui-ux-guidelines.md`, proses dulu sebelum lanjut kerja di modul terkait.
3. Setiap kali ada keputusan baru dari user (baik konfirmasi maupun perubahan arah),
   **tambahkan entri baru ke log kronologis di atas** (jangan edit entri lama — kalau ada
   keputusan yang membalik keputusan sebelumnya, tandai entri lama dengan coretan/catatan
   seperti pada #3, supaya jejaknya tetap kelihatan), lalu update dokumen teknis terkait.

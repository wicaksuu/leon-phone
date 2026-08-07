# 00 — Status & Decision Log

> **Baca file ini paling pertama, sebelum dokumen lain.** Ini bukan dokumen teknis — ini
> log keputusan + status terkini, supaya sesi AI baru (yang tidak punya histori chat
> sebelumnya) bisa langsung tahu di mana proyek berhenti dan kenapa keputusan tertentu
> diambil, tanpa mengulang pertanyaan yang user sudah jawab.

## Status saat ini

**Fase: 1 (Fondasi) — SEDANG BERJALAN.** Blueprint (`CLAUDE.md` + `docs/*`) sudah matang,
dan user sudah minta mulai coding ("bikin base laravel nya dulu yang lengkap"). Repo:
[github.com/wicaksuu/leon-phone](https://github.com/wicaksuu/leon-phone) (branch `main`).

**Yang sudah ada (jangan install/setup ulang, cek dulu sebelum asumsi belum ada)**:
- Laravel 13.24 + PHP 8.4.1, di root project ini (bukan subfolder)
- MySQL 8.0 lokal (database `leon_phone_rms`, lihat #14 di bawah — bukan MariaDB)
- Filament 4 dengan native Tenancy aktif (`app/Providers/Filament/AdminPanelProvider.php`
  → `->tenant(Tenant::class, slugAttribute: 'code')`)
- `Modules\` namespace ter-daftar di `composer.json` autoload, 18 folder modul dengan
  sub-folder standar sudah ada (banyak masih kosong/`.gitkeep` — itu wajar, isi sesuai
  kebutuhan modul masing-masing saat dikerjakan)
- Tenancy fondasi lengkap & TERUJI: migration `tenants`/`branches`/`tenant_user`/
  `warehouses`, model `Modules\Shared\Models\Tenant`, `Modules\MasterData\Models\{Branch,Warehouse}`,
  trait `Modules\Shared\Traits\BelongsToTenant` (auto-fill + global scope), service
  `Modules\Shared\Support\TenantContext` (baca dari `Filament::getTenant()`, override
  manual untuk test/artisan/API nanti)
- `Modules\Shared\Exceptions\DomainException` (base) + 2 contoh subclass
  (`InsufficientStockException`, `ImeiAlreadyExistsException`) + Handler mapping JSON di
  `bootstrap/app.php` (API/webhook) + trait `CatchesDomainExceptions` (pola notifikasi
  Filament, dipakai nanti saat ada Filament action pertama)
- Audit log generik: trait `Modules\Shared\Traits\Auditable` + `AuditLogObserver`, TERUJI
  (created/updated/deleted semua tercatat). **Catatan teknis penting**: JANGAN pakai
  `static::observe()` di dalam `boot{Trait}()` — itu memicu `new static` yang bikin
  Laravel error "may not be called on model while it is being booted" (re-entrancy).
  Pakai `static::created()`/`updated()`/`deleted()` langsung, lihat implementasinya di
  `Auditable.php` untuk pola yang benar.
- Pulse aktif, Reverb aktif (broadcasting=reverb, npm `laravel-echo`+`pusher-js`
  terinstall), Telescope **hanya register di local/staging** (lihat
  `AppServiceProvider::register()` — BUKAN di `bootstrap/providers.php`, sengaja supaya
  tidak boot sama sekali di production, bukan cuma di-gate akses)
- Pint bersih, Larastan level 5 bersih (1 info "trait unused" untuk
  `CatchesDomainExceptions` — wajar, belum ada consumer, bukan bug), PHPUnit 8 test lulus
  (unit: DomainException; feature: isolasi tenant + rollback transaksi — lihat
  `tests/Feature/Modules/MasterData/BranchTenantIsolationTest.php` sebagai TEMPLATE pola
  testing tenant untuk modul lain), skeleton `tests/k6/` + 1 script jalan (`_shared/smoke.js`)

**Belum ada** (jangan asumsi sudah ada): Role & Permission per-tenant, resource Filament
apapun (belum ada satu Resource/Page pun), route API (`routes/api.php` belum dibuat),
model bisnis modul manapun selain Tenant/Branch/Warehouse (Product, Order, IMEI, dll semua
masih kosong), seeder data contoh, deployment/hosting apapun.

**Sedang berlangsung (independen dari progress coding di atas)**: user mengumpulkan
screenshot referensi (produk sejenis: SISCOM ERP) secara bertahap ke folder `ref-gambar/`,
per-menu, untuk jadi acuan struktur & isi konten (bukan acuan gaya visual). Cek `CLAUDE.md`
§ Referensi visual untuk daftar yang sudah masuk vs yang masih ditunggu. **Kalau ada file
baru di `ref-gambar/` yang belum tercatat di log itu, itu artinya dokumen belum sinkron
dengan referensi terbaru — proses dulu sebelum lanjut kerja di area terkait.**

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

15. **Fase 1 mulai dieksekusi** ("bikin base laravel nya dulu yang lengkap biar ai koding
    sudah punya basic yang bagus dan proper"). Laravel di-install LANGSUNG di root project
    ini (bukan monorepo/subfolder terpisah — konsisten dengan keputusan #12, satu
    codebase). Database dinamai `leon_phone_rms`. Detail lengkap apa yang sudah dibangun
    & TERUJI ada di § Status saat ini di atas — jangan duplikasi di sini, itu yang selalu
    di-update tiap sesi kerja, bagian log ini isinya histori keputusan saja.

16. **Repo GitHub dibuat & di-push**: `github.com/wicaksuu/leon-phone`, branch `main`.
    User memberi personal access token GitHub langsung di chat untuk push pertama.
    **Token TIDAK disimpan mentah di `.git/config`** — dipakai untuk `gh auth login`
    sekali (tersimpan di macOS Keychain lewat `gh`), lalu `gh auth setup-git` supaya git
    push berikutnya otomatis lewat credential helper `gh`, bukan token di URL remote.
    **Catatan keamanan yang perlu disampaikan ke user** (kalau sesi berikutnya belum
    lihat ini ditindaklanjuti): token yang diberikan scope-nya sangat luas (`admin:org`,
    `delete_repo`, `admin:enterprise`, dst — jauh lebih dari sekadar `repo` yang
    dibutuhkan untuk push). Karena token itu sempat ditulis plaintext di chat, idealnya
    di-revoke dan diganti token baru dengan scope minimal (`repo` saja cukup) begitu ada
    kesempatan — ini belum ditindaklanjuti di sesi ini, cek apakah user sudah lakukan.

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

# 00 — Status & Decision Log

> **Baca file ini paling pertama, sebelum dokumen lain.** Ini bukan dokumen teknis — ini
> log keputusan + status terkini, supaya sesi AI baru (yang tidak punya histori chat
> sebelumnya) bisa langsung tahu di mana proyek berhenti dan kenapa keputusan tertentu
> diambil, tanpa mengulang pertanyaan yang user sudah jawab.

## Status saat ini

**Fase: 1 (Fondasi) — SEDANG BERJALAN, PERUBAHAN ARAH TECH STACK.** Blueprint (`CLAUDE.md`
+ `docs/*`) sudah matang. Repo:
[github.com/wicaksuu/leon-phone](https://github.com/wicaksuu/leon-phone) (branch `main`).
**Perubahan besar**: Filament **di-drop sepenuhnya** (lihat #19 di log keputusan), diganti
Tailwind CSS 4 + DaisyUI 5 + Laravel Breeze + layout custom ala Nexus Dashboard.

**Yang sudah ada (jangan install/setup ulang, cek dulu sebelum asumsi belum ada)**:
- Laravel 13.24 + PHP 8.4.1, di root project ini (bukan subfolder)
- MySQL 8.0 lokal (database `leon_phone_rms`, lihat #14 di bawah — bukan MariaDB)
- ~~Filament 4 dengan native Tenancy aktif~~ **USANG — akan dihapus** (lihat #19).
  Diganti Tailwind CSS 4 + DaisyUI 5 + Laravel Breeze + layout Nexus Dashboard
- `Modules\` namespace ter-daftar di `composer.json` autoload, 18 folder modul dengan
  sub-folder standar sudah ada (banyak masih kosong/`.gitkeep` — itu wajar, isi sesuai
  kebutuhan modul masing-masing saat dikerjakan)
- Tenancy fondasi lengkap & TERUJI: migration `tenants`/`branches`/`tenant_user`/
  `warehouses`, model `Modules\Shared\Models\Tenant`, `Modules\MasterData\Models\{Branch,Warehouse}`,
  trait `Modules\Shared\Traits\BelongsToTenant` (auto-fill + global scope), service
  `Modules\Shared\Support\TenantContext` (~~baca dari `Filament::getTenant()`~~ akan
  diubah ke session-based, lihat #19; override manual untuk test/artisan/API nanti)
- `Modules\Shared\Exceptions\DomainException` (base) + 2 contoh subclass
  (`InsufficientStockException`, `Modules\SerialNumber\Exceptions\DuplicateSerialUnitException`
  — nama terbaru, lihat #18) + Handler mapping JSON di `bootstrap/app.php` (API/webhook) +
  trait `CatchesDomainExceptions` (~~pola notifikasi Filament~~ akan diubah ke DaisyUI
  toast/alert, lihat #19)
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
- ~~**Navigasi sidebar lengkap** (`docs/00-status.md` #17): 27 halaman placeholder di
  `app/Filament/Pages/*Page.php`~~ **USANG — akan dihapus dan diganti** (lihat #19).
  Placeholder Filament ini akan diganti dengan Blade view + controller/Livewire component
  menggunakan layout drawer-based DaisyUI (Nexus Dashboard pattern).
- **Modul "IMEI Management" sudah di-rename jadi "Serial Number Management"** (`docs/00-status.md`
  #18) — `Modules/Imei/` **tidak ada lagi**, sekarang `Modules/SerialNumber/`. Kalau lihat
  referensi ke `Modules\Imei\...` di kode manapun (seharusnya tidak ada lagi setelah rename
  ini), itu bug/sisa lama yang harus diperbaiki, bukan pola yang harus diikuti.

**Belum ada** (jangan asumsi sudah ada): Role & Permission per-tenant, **isi asli** di
balik 27 halaman navigasi (semua masih placeholder "belum dibangun"), route API
(`routes/api.php` belum dibuat), model bisnis modul manapun selain Tenant/Branch/Warehouse
(Product, Order, SerialUnit, dll semua masih kosong), seeder data contoh (kecuali 1 tenant + 1
user percobaan lokal untuk testing manual, lihat #17), deployment/hosting apapun, layout
DaisyUI/Nexus Dashboard (belum diimplementasi, baru di-blueprint — lihat #19).

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

17. **Navigasi/sidebar Filament dibangun duluan, konten & label mirip referensi SISCOM,
    visual TETAP baru (belum dimodernkan).** User awalnya minta "sangat mirip" ke
    referensi (termasuk warna navy dll), lalu diklarifikasi ulang jadi lebih sempit:
    **cuma teks/label/struktur menu yang mirip, desain visual dimodernkan belakangan**
    ("tulisan dan isinya aja yang mirip untuk desain kan akan kita modernkan belakangan").
    Ini konsisten dengan keputusan awal di `docs/06-ui-ux-guidelines.md` (struktur ikut
    referensi, tampilan didesain baru) — sempat nyaris dibalik, tapi akhirnya balik lagi
    ke prinsip awal.
    - 27 halaman Filament placeholder dibuat di `app/Filament/Pages/*Page.php` +
      `resources/views/filament/pages/*.blade.php`, meng-cover semua 18 modul kita
      (bukan cuma 9 grup di referensi).
    - **Grup "Utiliti" sengaja meniru PERSIS 9 item di referensi** (Setting Cabang,
      Setting Default, Setting Password, Setting Menu User, Maintenance Data, Ganti
      Periode, Tutup Periode, Buka Kunci Data, Validasi Data) — walaupun
      `docs/02-modules.md` §18 secara konsep menaruh 4 item terakhir (manajemen periode)
      sebagai bagian dari modul Akuntansi. **Ini bukan kontradiksi**: pengelompokan
      NAVIGASI (presentasi/UX di sidebar) sengaja dibuat beda dari pengelompokan MODUL
      KODE (`Modules/Accounting/` tetap pemilik logic-nya) — nav grouping ≠ code module
      ownership. Kalau nanti dibangun betulan, Service-nya tetap di
      `Modules/Accounting/Services/`, cuma link navigasinya nampil di grup "Utiliti".
    - Semua halaman masih placeholder ("belum dibangun") — isi asli dibangun sesuai
      urutan `docs/07-roadmap.md`, bukan sekarang.
    - Diverifikasi jalan di browser (login pakai user percobaan `admin@leonphone.test` /
      `password`, tenant `leon` — data lokal, tidak di-push ke manapun karena DB tidak
      di-git). Screenshot tidak disimpan, cuma verifikasi visual sesi ini.
    - **Belum dikerjakan**: styling navy/premium (sengaja ditunda, "belakangan"), theme
      custom Filament (`php artisan make:filament-theme` belum dijalankan).

18. **"IMEI Management" digeneralisasi jadi "Serial Number Management".** User sadar IMEI
    cuma satu jenis identifier unit (khusus HP) — toko ini (lihat data contoh di
    `ref-gambar/` § dashboard: TV Polytron, TV Sharp, Samsung Smart TV, Arashi Mesin Cuci)
    jual banyak elektronik lain yang pakai Serial Number biasa, bukan IMEI. Modul
    di-generalisasi supaya satu struktur (histori append-only, lifecycle
    supplier→gudang→order→garansi→retur) berlaku untuk KEDUANYA, dibedakan lewat kolom
    `identifier_type`. Keputusan terkait:
    - **IMEI jadi salah satu TIPE** di dalam modul yang lebih umum (bukan dua modul
      terpisah) — opsi yang dipilih user vs alternatif "Unit Tracking" (nama lebih netral,
      tidak dipilih).
    - **Barang tanpa identifier individual sama sekali** (aksesoris, sparepart kecil)
      **TETAP** di `stock_items` (quantity-based, terpisah dari modul ini) — TIDAK
      dipaksa masuk sebagai unit ber-`identifier_type=none`. Modul Serial Number Management
      HANYA untuk barang yang tiap unit fisiknya perlu histori individual.
    - Kode yang sudah ada di-rename (bukan ditulis ulang dari nol): folder
      `Modules/Imei/` → `Modules/SerialNumber/` (git mv, histori terjaga), exception
      `ImeiAlreadyExistsException` → `DuplicateSerialUnitException` (constructor sekarang
      terima `SerialIdentifierType $type` biar pesan errornya bisa "IMEI ... sudah
      terdaftar" ATAU "Serial Number ... sudah terdaftar" tergantung tipe), enum baru
      `Modules\SerialNumber\Enums\SerialIdentifierType` (`Imei` | `SerialNumber`), nav
      Filament `ImeiManagementPage` → `SerialNumberPage` (label sidebar: "Serial Number").
    - Skema database `imeis`/`imei_histories` → `serial_units`/`serial_unit_histories`
      dengan kolom `identifier_type` + `identifier_value` (dulu cuma kolom `imei`). Detail
      lengkap → `docs/04-database.md` § Serial unit lifecycle.
    - Semua dokumen (`CLAUDE.md`, `docs/01` `02` `03` `04` `05` `06` `07`) sudah
      disinkronkan mengikuti rename ini. `docs/08-tenancy.md` tidak menyebut IMEI sama
      sekali, tidak perlu diubah.
    - **Belum ditindaklanjuti**: `graphify-out/` belum di-`--update` lagi setelah rename
      ini (IMEI masih jadi salah satu node sentral/god node di graph lama) — jalankan
      `/graphify --update` kalau user minta graph disegarkan lagi.
    - Nama produk "LEON PHONE" (brand) **TIDAK diubah** — ini keputusan sempit soal
      modul IMEI/Serial Number saja, bukan rebrand. Kalau nanti user juga minta
      generalisasi visi/nama produk dari "toko HP" ke "toko elektronik", itu perubahan
      terpisah, jangan diasumsikan dari entri ini.

19. **~~Frontend/admin panel: Filament~~ → DIBALIK, drop Filament sepenuhnya. Ganti ke
    Tailwind CSS 4 + DaisyUI 5 + Laravel Breeze + layout custom (Nexus Dashboard).** Semua
    keputusan sebelumnya yang menjadikan Filament sebagai tulang punggung admin panel (#6,
    #12, #17) **sudah tidak berlaku lagi**. Keputusan baru:
    - **Styling**: **Tailwind CSS 4 + DaisyUI 5** — DaisyUI memberikan component library
      siap pakai (button, card, table, modal, drawer, navbar, toast, dll) + semantic color
      tokens + theming/dark mode built-in via `data-theme` attribute.
    - **Auth**: **Laravel Breeze** (Blade stack) — menggantikan Filament auth. Breeze
      menyediakan login/register/reset password + controller + view yang bisa dicustomisasi
      sepenuhnya, sudah include Tailwind CSS.
    - **Layout dashboard**: mengikuti pola **DaisyUI Nexus Dashboard (Growth)**
      (`https://nexus.daisyui.com/dashboards/growth`) — drawer-based sidebar (DaisyUI
      `drawer`, `lg:drawer-open` di desktop, collapsible di mobile) + top header/navbar
      (DaisyUI `navbar`, sticky, berisi search/notif/tenant-switcher/user-menu) + main
      content area grid-based.
    - **CRUD/admin**: dibangun manual menggunakan **Blade + Livewire + DaisyUI components**
      (table, form, modal) — bukan lagi Filament Resource.
    - **Tenancy**: Filament native Tenancy (`Panel::tenant()`, `Filament::getTenant()`)
      **dihapus**. Diganti dengan mekanisme custom: **session-based tenant context +
      middleware `ResolveTenantContext`** + dropdown tenant switcher di header/navbar
      (DaisyUI dropdown component). `TenantContext` singleton tetap dipakai, tapi sumber
      tenant-nya dari session (bukan dari Filament).
    - **27 halaman placeholder Filament** (`app/Filament/Pages/*Page.php` +
      `resources/views/filament/pages/*.blade.php`) **akan dihapus** dan digantikan dengan
      Blade view + controller/Livewire component menggunakan layout drawer-based DaisyUI.
    - **Konsekuensi untuk navigasi sidebar**: sebelumnya Filament otomatis generate sidebar
      dari Page/Resource yang terdaftar. Sekarang sidebar dibangun manual sebagai Blade
      component dalam layout drawer, dengan menu items yang dikonfigurasi secara eksplisit.
    - **Konsekuensi untuk Livewire custom** (POS Kasir, Packing Station): sebelumnya
      berjalan DI DALAM Filament panel sebagai custom page. Sekarang berjalan di dalam
      layout drawer-based yang sama — tidak ada lagi perbedaan "Filament page" vs "Livewire
      custom page", semuanya pakai layout yang sama.
    - Entri #6, #12, #17 di atas **dibiarkan tercatat apa adanya** (bukan dihapus) supaya
      jejak perubahan arah tetap kelihatan.

20. **Audit langsung ke aplikasi live SISCOM ERP dimulai** (`myapp.siscom.id`, database
    `leon` = tenant asli Leon Sellular Indonesia). User login manual (password tidak
    ditangani AI — sesuai kebijakan kredensial), AI cuma navigasi/baca setelah login,
    **TIDAK klik tombol Save/Submit/Delete apapun** (instruksi eksplisit user, diulang
    beberapa kali: "jangan sampai menambah atau mengurangi data ketika proses"). Batasan
    teknis yang disepakati: AI cuma boleh fetch/klik **link navigasi menu sidebar**
    (halaman `*Listing`/`*Form` yang sama dengan yang user sendiri bisa klik), **TIDAK
    PERNAH** fetch/klik ikon Actions per-baris (edit/lock/hapus) — di app lama seperti
    ini ikon-ikon itu berpotensi jadi GET yang destruktif, jadi sengaja dihindari total.

    **~~Audit manual halaman-per-halaman (klik+screenshot), disimpan di
    `docs/siscom-reference/`~~ → DIHAPUS, PREMATUR.** Percobaan pertama (manual click +
    screenshot + tulis catatan satu-satu) dihentikan setelah baru ~9 halaman dari
    ratusan — user nilai datanya jelas belum lengkap/representatif untuk jadi acuan,
    semua file di `docs/siscom-reference/` **dihapus total**. Jangan diasumsikan folder
    itu masih ada atau berisi apa-apa.

    **Metode baru (belum dieksekusi ulang saat entri ini ditulis)**: fetch HTML mentah
    tiap halaman langsung via `fetch(url, {credentials:'include'})` dari dalam konteks
    browser yang sudah login (pakai `mcp__claude-in-chrome__javascript_tool`), parse
    tabel/form-nya via `DOMParser`, ambil SEMUA kolom header (termasuk yang tersembunyi
    dari tampilan default — contoh: `Order Penjualan` ternyata py 36 kolom di HTML,
    bukan cuma ~11 yang kelihatan di UI). Ini jauh lebih cepat & lengkap daripada klik
    manual. User eksplisit minta: **audit sampai ke level sub-submenu (mis. Perakitan →
    Pemakaian Bahan Baku/Penyelesaian Barang Jadi), lalu dibandingkan apakah desain kita
    sudah 100% cocok atau belum** — bukan cuma sampling beberapa halaman seperti
    percobaan pertama.

    **Temuan yang TETAP BERLAKU meski catatan detailnya dihapus** (sudah dikonfirmasi
    user, sudah dieksekusi ke skema): dari audit singkat `Master Barang`, SISCOM
    **tidak membedakan IMEI vs Serial Number sebagai dua tipe berbeda** — cuma satu flag
    "Tracking: (1) Barang Dengan Serial Number/Imei" vs tanpa. **`SerialIdentifierType`
    enum (Imei/SerialNumber) SUDAH DIHAPUS dari desain**, diganti kolom
    `identifier_value` polos tanpa tipe di `serial_units` (`docs/04-database.md` sudah
    diupdate, lihat § Serial unit lifecycle). Ini keputusan FINAL, bukan bagian dari
    audit yang dihapus.

    **Status: SELESAI (sweep pertama).** Audit ulang dengan metode fetch+DOMParser
    berhasil cover **82 halaman unik** sampai level sub-submenu (Dashboard, Persediaan,
    Pembelian, Penjualan, Keuangan, Akunting, Utiliti, Saldo Awal, Help/Tools — termasuk
    sub-sub seperti Perakitan→Pemakaian Bahan Baku, Keuangan→Hutang Dagang→Pembayaran,
    Help→Tools→Kroscek Imei). Hasil:
    - `docs/siscom-reference/01-field-inventory.md` — field lengkap per halaman (raw
      truth, kolom generik audit-trail Doe/Toe/Loe/Deo/Actions sengaja tidak dicatat
      berulang).
    - `docs/siscom-reference/02-gap-analysis.md` — **jawaban eksplisit "sudah 100% sama
      atau belum": BELUM.** Struktur/alur besar kita sudah selaras, tapi jauh lebih
      sederhana di level field. Gap terbesar: (1) status "Tutup" eksplisit untuk
      PR/PO/SO — partial fulfillment tidak ada di desain kita, (2) **E-Faktur** (pajak
      elektronik DJP) sama sekali tidak ada di blueprint, (3) **Aktiva Tetap/Fixed
      Assets** modul penuh tidak ada, (4) Cost Centre sebagai dimensi COA tidak ada,
      (5) credit limit management Supplier/Customer belum ada. Detail lengkap +
      rekomendasi prioritas ada di file itu — **belum ada satu pun gap yang
      ditindaklanjuti ke `docs/02-modules.md`/`docs/04-database.md`**, semua masih
      perlu dikonfirmasi user satu-satu dulu.
    - `docs/siscom-reference/html/` — HTML mentah 82 halaman (~14MB) tersimpan LOKAL
      saja, **TIDAK di-commit** (`.gitignore`, isu hak cipta aplikasi pihak ketiga).
      Kalau sesi berikutnya jalan di mesin lain, folder ini tidak akan ada.
    - Halaman "Laporan *" (murni report) TIDAK di-audit detail satu-satu — kebanyakan
      cuma form filter kosong sebelum submit, minim info baru. Kalau perlu detail
      laporan spesifik nanti, audit ulang halaman itu saja saat itu.

21. **Koreksi kejujuran atas klaim "SELESAI" di #20** — user tanya eksplisit "apakah
    semua halaman sudah 100%, termasuk inputan waktu tambah?" dan jawabannya waktu itu
    TIDAK. Yang benar-benar tercapai di #20 cuma kolom **listing** (tabel), BUKAN field
    form **"Tambah Data"** (create record baru) — itu 2 hal beda. Setelah ditegur,
    ditindaklanjuti sebagian:
    - Ditemukan pola: tombol "+" tiap listing kadang `href` langsung ke `add{Nama}`,
      kadang lewat JS `onclick="otorisasiAdd()"` (cek otorisasi mundur-tanggal dulu).
      42 URL "Tambah" berhasil diidentifikasi dari HTML tersimpan (grep, bukan fetch
      ulang — hemat).
    - **Temuan bug di kode SISCOM sendiri**: 10 halaman transaksi (`piListing`,
      `siListing`, `apPaymentListing`, `arReceiptListing`, `poCloseListing`,
      `pqCloseListing`, `soCloseListing`, `sqCloseListing`, `prListing`, `roListing`)
      semua py `otorisasiAdd()` yang redirect ke `addPo` — kemungkinan besar
      copy-paste bug (fungsi disalin dari halaman PO, lupa update tujuan). URL-nya
      TIDAK dipakai/dipercaya untuk audit field.
    - Dari 42 URL, baru **13 yang benar-benar di-fetch detail field-nya**:
      `addGoods`, `addWh`, `addStockOpname`, `addTransferWh`, `addAdjustStock`,
      `addSupp`, `addPq`, `addCust`, `addSo`, `addCoa`, `addFa`, `addPayType`, `addCc`.
      Hasil → `docs/siscom-reference/03-add-form-fields.md`. Temuan baru penting:
      Master Barang py **Multi Satuan** (konversi unit, GAP vs skema kita yang cuma 1
      Satuan/produk), COA py **6 segmen akun + Cost Centre wajib + Anggaran/Thn**
      (budgeting terintegrasi — GAP baru), Fixed Assets py **jadwal depresiasi
      otomatis** (Periode Susut, Penyusutan per bulan, posting DR/CR otomatis).
    - **29 URL lain sudah diidentifikasi tapi field-nya BELUM diambil.** ~21 halaman
      lagi (userListing, branchListing, dll) bahkan URL "Tambah"-nya belum
      teridentifikasi (grep otomatis tidak menangkap polanya).
    - **Edit form**: cuma 1 dari 82 halaman yang PERNAH dibuka (Master Barang, manual,
      sebelum dihapus di #20). 81 form edit lainnya belum pernah disentuh sama sekali.
    - **Kesimpulan jujur untuk sesi berikutnya**: audit BELUM 100% lengkap. Kalau user
      minta lanjut, kerjaan yang tersisa ada di
      `docs/siscom-reference/03-add-form-fields.md` § "Belum diverifikasi"/"Belum sama
      sekali" — lanjutkan dari situ, JANGAN klaim selesai lagi sebelum benar-benar
      dicek ulang menyeluruh (create form + edit form, bukan cuma listing).

22. **Menutup gap form "Tambah" dari #21** — lanjutan langsung dari #21 ("lanjutkan
    sisanya, pastikan download semua html nya"). Semua 42 URL "Tambah" yang
    teridentifikasi sekarang **sudah di-fetch field-nya + HTML mentahnya disimpan**
    (total `docs/siscom-reference/html/` sekarang 122 file: 82 listing + 40 form
    tambah). Rincian:
    - 29 URL yang sebelumnya "belum diverifikasi" + `addAdjustStock` (kelewat di #21)
      → semua berhasil di-fetch.
    - 5 URL pengganti untuk halaman kena bug `otorisasiAdd()`→`addPo` (dari #21)
      berhasil ditebak & diverifikasi (HTTP 200 + judul halaman cocok): `addSi`,
      `addApPayment`, `addArReceipt`, `addPr`, `addRo`.
    - `addGl` dikonfirmasi **tidak ada** (404 → redirect ke `pageNotFound`) — General
      Ledger murni view otomatis dari posting jurnal, tidak ada create manual.
    - 6 listing (`userListing`, `branchListing`, `apBeginListing`, `arBeginListing`,
      `userMenuListing`, `logListing`) dikonfirmasi **tidak punya tombol Tambah sama
      sekali** — satu-satunya link `/add*` yang ada di halaman itu adalah
      `addPosForm`, ternyata shortcut sidebar GLOBAL yang muncul di semua halaman,
      bukan tombol spesifik (sempat jadi false-positive di analisis awal).
    - Temuan baru yang cukup penting untuk desain: **DO (Delivery Order) py field
      `listimei`/`tempflagimei`** — konfirmasi scan IMEI/Serial terjadi di tahap
      packing/pengiriman (DO), BUKAN di Invoice — cocok dgn asumsi desain kita soal
      Packing Station. **Retur Penjualan (`addSr`) wajib "Berdasarkan" + "Pilih
      Faktur SI"** — retur selalu merujuk invoice asal spesifik, bukan retur bebas.
      **Jurnal Manual (`addJournal`) py validasi real-time `selisih` (debit-kredit)**
      harus 0 sebelum submit. **Cheque/Giro (`addChequeTransaction`) + Transaksi Bank
      (`addBankTransaction`) saling terhubung** — payment via giro terintegrasi
      langsung di `addApPayment`/`addArReceipt` juga (field `gironormalTemp` dst),
      bukan modul terpisah yang harus dibuka manual.
    - Hasil lengkap → `docs/siscom-reference/03-add-form-fields.md` (ditulis ulang
      total, bukan cuma ditambah).
    - **Yang MASIH belum tercakup (jangan klaim 100% lengkap)**: (a) form **EDIT**
      masih 1/82 — gap besar yang belum disentuh sama sekali di putaran ini karena
      user cuma minta lanjutkan "Tambah"; (b) ~21 halaman "murni form aksi" (mis.
      `changePeriod`, `eFakturForm`, `dataMaintenanceForm`) belum diaudit field-nya
      karena bukan pola listing+tambah — kalau dibutuhkan, perlu putaran terpisah;
      (c) field yang dicatat di `03-add-form-fields.md` masih level LABEL ringkas
      (bukan semua atribut HTML/opsi dropdown/JS validasi) — untuk detail penuh, buka
      file HTML mentah terkait di `html/`.
    - Semua file HTML baru dipindah dari `~/Downloads/` (metode Blob-download, sesuai
      #20/#21 — `document.cookie` tetap diblokir extension jadi tidak bisa pakai
      curl+cookie) ke `docs/siscom-reference/html/` via `mv`, termasuk membuang 3 file
      duplikat hasil auto-rename Chrome (`(1).html`) dari percobaan fetch yang
      sempat ke-truncate outputnya di sesi sebelumnya (isi filenya identik, bukan
      hilang data — cuma nama file dobel).

23. **Mulai audit form Edit** (permintaan user: "lanjut audit form Edit juga") — beda
    metode dari form Tambah karena butuh ID record ASLI (bukan cuma 1 URL statis per
    halaman). Ditemukan 2 pola render listing SISCOM: (a) **server-rendered** — HTML
    awal sudah berisi baris data asli + href edit valid, ID bisa langsung diambil dari
    `html/` tanpa fetch tambahan; (b) **client-rendered via AJAX** — HTML awal cuma
    kerangka kosong, baris baru muncul setelah AJAX terpanggil.
    - Untuk pola (b), dicek via network inspection di `soListing`: **AJAX list data
      TIDAK auto-terpanggil saat page load** — baru terpanggil setelah user submit
      form filter/cari. Ini berlaku untuk hampir semua modul TRANSAKSI (SO, SI, PO,
      PQ, PR, RO, PI, DO, SQ, Journal, dll).
    - **Berhenti di 15/82 halaman edit** (bukan 82) karena mendapat ID record dari
      modul transaksi butuh submit form filter — di luar batas kerja "GET/navigate
      saja, jangan submit apapun" yang disepakati sejak awal audit (`docs/00-status.md`
      #20-21). **Tidak diinterpretasikan sendiri sebagai "aman karena cuma filter"** —
      sengaja berhenti untuk minta konfirmasi eksplisit user dulu.
    - 15 halaman yang berhasil (field lengkap + HTML tersimpan) → editWh, editBrand,
      editUnit, editCc, editBranch, editSupp, editCust, editSalesman, editPayType,
      editBank, editFa, editUser, editSr, editApPayment, editArReceipt. 1 gagal
      (editUserMenuForm/L01 → "Database Error", tidak dikejar lebih jauh karena area
      User/Access Management sensitif untuk uji berulang).
    - **Temuan pola penting untuk desain**: 14 dari 15 halaman edit punya field SET
      IDENTIK dengan form Tambah-nya (cuma di-pre-fill) — konfirmasi bahwa 1 komponen
      form dengan optional `$record` (pola Laravel standar) sudah cukup, TIDAK perlu
      Blade/form terpisah per Create vs Edit. Beberapa field ekstra ketemu di Edit yang
      terlewat di ekstraksi Tambah (Kode Pajak di Satuan, Kartu/Uang Muka di Tipe
      Bayar, Salesman di Retur Penjualan) — kemungkinan cuma soal metode ekstraksi
      (field di scroll/tab lanjutan), bukan field yang benar-benar cuma ada di Edit.
    - Hasil lengkap → `docs/siscom-reference/04-edit-form-fields.md` (file baru).
      `html/` sekarang 137 file (82 listing + 42 add-form + 15 edit-form).
    - **PERTANYAAN TERBUKA untuk sesi berikutnya / user**: apakah submit form
      filter/cari (search-only, TIDAK create/update/delete apapun) dianggap masih
      dalam batas aman audit ini? Kalau ya, ~65 halaman transaksi sisanya bisa
      dilanjutkan dengan metode itu. Kalau tidak, form Edit modul transaksi
      dianggap TIDAK BISA diaudit lewat live app tanpa risiko melanggar batas kerja
      yang diminta user — perlu cara lain (mis. user sendiri yang screenshot/export).

24. **Lanjut audit form Edit setelah user konfirmasi submit form filter/cari diizinkan**
    (jawaban eksplisit user atas pertanyaan terbuka di #23: "Ya, boleh"). Ditemukan
    metode efisien: form `#searchList` tiap listing POST balik ke URL listing itu
    sendiri (server re-render HTML lengkap) — jadi cukup `fetch(url, {method:'POST',
    body: <default form fields>, credentials:'include'})` tanpa perlu navigasi tab
    sama sekali, lalu parse baris pertama utk ambil ID record asli dari atribut
    `onclick`/`ondblclick` (pola `openRowEdit('ID',...)` / `otorisasiEdit(tgl,'ID',...)`).
    - **6 halaman baru berhasil** (naik dari 15 → **21/82**): `editSiForm`,
      `editPiForm`, `editGoodsGroupForm`, `editCustGroupForm`, `editSuppGroupForm`,
      `editGoodsForm` (yang terakhir via cara lain — endpoint pencarian barang
      `Utility/searchBarangNama` — karena `goodsListing` ternyata pakai AJAX endpoint
      terpisah `Mpersediaan/getGoodsList`, bukan pola POST-balik-ke-diri-sendiri).
    - **Temuan bisnis penting, dicek satu-satu (bukan diasumsikan)**: 25 halaman
      lain (SO, PO, DO, SQ, PQ, RO, PR-related, AdjustStock, Ap/ArDownPayment,
      ArInvoice, CashBank Payment/Receipt, Journal, StockOpname, TransferWh/Temp,
      Recurring, Promo, RawMaterial, FinMaterial, Size, SalesPriceGroup,
      BankTransaction, ChequeTransaction, PoClose, SoClose) **dicek via submit form
      filter kosong/default dan hasilnya 0 baris data** — dikonfirmasi BUKAN
      kegagalan metode (metode terbukti jalan normal di halaman yang memang ada
      datanya). Kesimpulan: tenant "leon" sejauh ini baru pakai Faktur Penjualan
      (SI) + Faktur Pembelian (PI) + master data dasar secara langsung, **belum
      pernah menyentuh alur formal Quote→Order→Delivery, AP/AR down payment,
      cash/bank/giro, jurnal manual, atau stock opname/adjust/transfer**. Field
      Edit modul-modul itu, kalau dibutuhkan, pakai struktur form Tambah yang
      sudah terdokumentasi sbg fallback (sudah terbukti 20/21 halaman = Edit
      reuse Tambah).
    - `coaListing` masih belum tertelusuri (pakai AJAX endpoint terpisah seperti
      goodsListing, belum ditemukan endpoint aslinya) — BUKAN kosong (COA pasti
      ada datanya, terkonfirmasi tidak langsung lewat `editFaForm` yang referensi
      akun aktif), cuma metodenya belum ketemu.
    - Hasil lengkap → `docs/siscom-reference/04-edit-form-fields.md` (ditulis
      ulang, bukan cuma ditambah). `html/` sekarang 143 file.

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

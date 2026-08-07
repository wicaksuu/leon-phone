# 08 — Tenancy (Multi-PT)

Lihat riwayat keputusan lengkap → `docs/00-status.md` #3. Ringkas: sistem ini SaaS,
melayani banyak PT sekaligus, isolasi data pakai **shared database + kolom `tenant_id`**
(bukan database terpisah per PT).

## Kenapa bukan database terpisah per PT

Referensi visual (`ref-gambar/`, screenshot halaman pilih-PT) menunjukkan produk sejenis
(SISCOM ERP) memakai database terpisah per PT — user login ke portal akun pusat, lalu
pilih "database" (=PT) mana yang mau dibuka, tiap PT literally instance database MySQL
sendiri. **Kita sengaja tidak ikut pola itu**: shared DB + `tenant_id` jauh lebih sederhana
dioperasikan (satu migration run, satu backup job, satu connection pool) untuk skala yang
direncanakan sekarang. Trade-off yang disadari: kalau nanti ada PT yang butuh isolasi
fisik penuh (compliance, performa ekstrem), itu jadi migrasi besar yang disengaja — bukan
sesuatu yang diantisipasi sejak awal (sama seperti prinsip di `docs/01-vision.md`).

Yang **tetap diambil** dari referensi: pengalaman "pilih PT setelah login" (tenant
switcher) — cuma mekanismenya beda: bukan pilih database, tapi pilih tenant context dalam
satu database yang sama.

## Model data inti

```
tenants                    -- satu row = satu PT
  id, name, code (mis. "01" seperti di referensi), logo, subscription_status
  (active/expired/suspended), subscription_expires_at, created_at

tenant_user                -- pivot: satu user bisa akses banyak PT, satu PT banyak user
  id, tenant_id, user_id, role_id (role SPESIFIK per tenant — Kasir di PT A belum tentu
  Kasir di PT B), created_at

branches                   -- Cabang, anak dari tenant
  id, tenant_id, name, code, address, created_at

warehouses                 -- Gudang, anak dari Cabang (bukan langsung anak dari tenant)
  id, tenant_id, branch_id, name, ...
```

`tenant_id` didobel-simpan di `warehouses` (meski bisa didapat lewat `branch_id`) supaya
query scoping tidak perlu join ke `branches` tiap kali — ini pola yang dipakai di SEMUA
tabel turunan, lihat § Aturan wajib di bawah.

Setiap tabel bisnis lain (products, orders, imeis, dst — lihat `docs/04-database.md`) juga
punya kolom `tenant_id` langsung, bukan cuma diturunkan dari relasi.

## Resolusi tenant context — satu mekanisme untuk Filament & API

Filament+Livewire (primary UI) dan REST API (sekunder — webhook marketplace, app mobile
masa depan) adalah dua entry point berbeda ke Laravel yang sama. Supaya scoping tenant
tidak diimplementasi dua kali secara berbeda (dan berisiko lupa di salah satu), keduanya
**wajib lewat mekanisme yang sama**:

1. Middleware `ResolveTenantContext` (dipasang di route group Filament panel DAN route
   group `api.php`) menentukan tenant aktif dari user yang sedang login, lalu menyimpan
   ke sebuah singleton `TenantContext` (`app()->instance(...)`) untuk request tersebut.
2. Trait `BelongsToTenant` di-attach ke semua Model bisnis → daftarkan global scope yang
   otomatis `WHERE tenant_id = ?` dari `TenantContext`, dan otomatis isi `tenant_id` saat
   create.
3. **`tenant_id` TIDAK PERNAH dipercaya dari input client** (form Filament, body request
   API, header custom dari frontend) — selalu diturunkan dari `TenantContext` sisi
   server. Kalau frontend kirim `tenant_id` yang beda dari context aktif, itu bug atau
   percobaan serangan, bukan hal yang di-follow.

### Sisi Filament (primary — satu-satunya UI, lihat `docs/00-status.md` #12)
Pakai fitur **native Tenancy** Filament (`Panel::tenant(Tenant::class)`): otomatis
render tenant switcher di header (setara dropdown "PT. ENAM JALAN DEWA ELEKTRONIK (01)" di
referensi, ini yang jadi pengganti langsung halaman "pilih PT" di referensi — bukan lewat
API terpisah), otomatis scope query resource. Livewire custom page (POS Kasir, Packing
Station) berjalan DI DALAM konteks Filament panel yang sama, jadi otomatis ikut tenant
aktif tanpa mekanisme tambahan. `ResolveTenantContext` middleware sinkron dengan tenant
yang dipilih Filament.

### Sisi API (sekunder — webhook marketplace, app mobile masa depan)
Bukan primary interface (lihat `docs/00-status.md` #12), tapi tetap butuh resolusi tenant
yang benar untuk dua kasus: webhook marketplace (tenant ditentukan dari konfigurasi
integrasi yang di-hit, bukan dari user login) dan app mobile staf gudang di masa depan
(kalau dibuat, baru butuh endpoint tenant-switcher API serupa `GET /api/me/tenants`).

## Role & permission — per tenant, bukan global

Satu user bisa punya role berbeda di PT berbeda (mis. jadi Owner di PT sendiri, tapi cuma
Kasir kalau diundang bantu di PT lain). Role & permission (`docs/02-modules.md` § HR)
di-assign lewat `tenant_user.role_id`, bukan kolom role global di tabel `users`.

## Platform admin (di luar konteks tenant manapun)

Ada satu lapis akses lagi di luar semua PT: **platform admin** (staf pemilik sistem SaaS
ini, bukan staf salah satu PT) — kelola daftar tenant, approve pendaftaran PT baru,
suspend PT yang subscription-nya expired. Ini panel Filament TERPISAH (bukan bagian dari
panel per-tenant), dengan model `User` yang sama tapi tanpa relasi ke `tenant_user` mana
pun yang relevan untuk akses ini.

## Testing wajib untuk tenancy

Setiap fitur baru yang menyentuh data bisnis WAJIB punya minimal satu Feature test yang
membuktikan **isolasi antar tenant**: buat data di tenant A, login sebagai user tenant B,
pastikan data tenant A tidak muncul/tidak bisa diakses (termasuk lewat akses langsung by
ID — bukan cuma di listing). Ini bagian dari trio testing wajib di
`docs/05-coding-standards.md` § Testing, bukan test tambahan opsional.

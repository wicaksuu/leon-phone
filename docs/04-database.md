# 04 — Database (MySQL 8.0)

> Riwayat: dokumen ini awalnya berjudul "Database (MariaDB)". Dibalik ke MySQL 8.0 saat
> instalasi Laravel dimulai — lihat `docs/00-status.md` #14. Konvensi di bawah ini sama
> persis berlakunya untuk MySQL 8.0 (semuanya fitur standar `InnoDB`/`utf8mb4`, tidak ada
> yang MariaDB-spesifik).

## Konvensi umum

- Engine `InnoDB` di semua tabel (wajib untuk foreign key + transaction).
- Charset `utf8mb4` (dukung emoji di catatan/keluhan servis, nama customer, dll).
- Primary key `BIGINT UNSIGNED AUTO_INCREMENT id`, konsisten dengan konvensi Laravel.
- Foreign key eksplisit dengan `onDelete('restrict')` sebagai default — data operasional
  (stok, order, unit ber-IMEI/Serial Number) **tidak boleh** terhapus cascade diam-diam.
  Soft delete (`deleted_at`) dipakai di master data (Produk, Customer, Supplier), bukan di
  transaksi.
- Nama tabel: snake_case jamak (`purchase_orders`, `serial_unit_histories`).
- Setiap tabel transaksi/master penting punya `created_by` / `updated_by` (FK ke `users`)
  selain timestamp standar — dasar untuk audit log.
- **`tenant_id` (FK ke `tenants`) wajib di SEMUA tabel bisnis** (lihat `docs/08-tenancy.md`)
  — diisi otomatis lewat trait `BelongsToTenant`, tidak pernah manual. Index composite
  yang diawali `tenant_id` di tabel-tabel besar (mis. `(tenant_id, status)` di `orders`)
  supaya query yang selalu ter-filter tenant tetap cepat.

## Tenancy & lokasi

```
tenants
  id, name, code, logo_path, subscription_status (enum: active/expired/suspended),
  subscription_expires_at, created_at

tenant_user   -- pivot, satu user bisa akses banyak tenant dengan role berbeda-beda
  id, tenant_id, user_id, role_id, created_at

branches      -- Cabang
  id, tenant_id, name, code, address, created_at

warehouses    -- Gudang, anak dari Cabang
  id, tenant_id, branch_id, name, ...
```

Detail penuh model tenancy (kenapa shared-DB, resolusi tenant context, dst) → `docs/08-tenancy.md`.

## Entitas kunci

### Serial unit lifecycle
> Digeneralisasi dari "IMEI lifecycle" (`docs/00-status.md` #18) — IMEI cuma satu **tipe**
> identifier (khusus HP), barang elektronik lain (TV, mesin cuci, dst — lihat contoh
> produk di `ref-gambar/`) pakai Serial Number biasa.
>
> **Disederhanakan lagi** (`docs/00-status.md` #20, hasil audit langsung ke SISCOM ERP —
> `docs/siscom-reference/03-master-barang.md` § Tracking): SISCOM sendiri **tidak
> membedakan IMEI vs Serial Number sebagai dua tipe berbeda** di levelnya — cuma satu flag
> "unit ber-identifier" vs "tidak". Kita ikuti pola itu: **tidak ada lagi kolom
> `identifier_type`**, cukup `identifier_value` polos. IMEI dan Serial Number diperlakukan
> 100% sama secara sistem (histori, validasi unique, scan flow) — bedanya cuma FORMAT
> string, dan format tidak menentukan cabang logic apapun, jadi tidak perlu jadi kolom
> enum. Kalau nanti butuh validasi format (mis. IMEI harus 15 digit Luhn-valid), itu
> validasi opsional di level Request/Rule, bukan tipe data.

Satu tabel `serial_units` (unit fisik) + satu tabel `serial_unit_histories` (log kejadian,
append-only). `identifier_value` unique **per tenant** (`unique(tenant_id, identifier_value)`),
bukan global — dua tenant berbeda secara teori bisa punya entri untuk identifier yang
"sama" kalau datanya salah input, sistem tidak menganggap itu error lintas-tenant karena
mereka memang tidak saling tahu.

```
serial_units
  id, tenant_id, identifier_value, product_variant_id,
  current_status (enum: in_stock/reserved/sold/returned/service/lost/damaged),
  current_warehouse_id, current_rack_id, current_marketplace_id (nullable),
  created_at, updated_at

serial_unit_histories   (append-only — tidak pernah di-update/delete)
  id, tenant_id, serial_unit_id, event_type (enum: received/moved/reserved/sold/returned/
  warranty_claim/service/lost/found), reference_type, reference_id (polymorphic ke PO/
  Order/Return/Warranty/Service), warehouse_id, notes, actor_id, created_at
```

`current_status` di `serial_units` adalah **proyeksi/cache** dari histori terbaru — sumber
kebenaran tetap `serial_unit_histories`. Kalau ada bug ketidaksesuaian, rebuild
`current_status` dari histori, jangan pernah edit `current_status` manual tanpa entry
histori baru.

### Stock (agregat, terpisah dari serial_units untuk barang tanpa identifier individual
seperti aksesoris)
```
stock_items
  id, tenant_id, product_variant_id, warehouse_id, rack_id (nullable),
  marketplace_id (nullable), status (enum: available/reserved/damaged/lost), quantity,
  updated_at
```
Untuk produk ber-unit (HP via IMEI, elektronik lain via Serial Number), `quantity` selalu
1 dan idealnya sinkron 1:1 dengan `serial_units` yang statusnya sesuai — validasi ini
dijalankan sebagai invariant check, bukan constraint DB literal (karena melibatkan logika
lintas tabel).

### Order (satu struktur untuk semua channel)
```
orders
  id, tenant_id, order_number (unique per tenant_id), channel (enum: pos/shopee/
  tokopedia/tiktok/lazada/blibli/...), customer_id, status (enum sesuai alur di
  02-modules.md § Order Management), subtotal, discount, shipping_cost, grand_total,
  courier_id, payment_method_id, paid_at, branch_id, warehouse_id (asal pengiriman),
  created_at, updated_at

order_items
  id, tenant_id, order_id, product_variant_id, serial_unit_id (nullable — hanya untuk
  produk ber-unit/IMEI/Serial Number), qty, price, discount

order_status_histories   (append-only, sama prinsipnya dengan serial_unit_histories)
  id, tenant_id, order_id, from_status, to_status, actor_id, notes, created_at
```

### Approval workflow (dipakai lintas modul: harga, stock adjustment, cancel order, retur,
buka kunci periode akuntansi — lihat `02-modules.md` §18)
```
approval_requests
  id, tenant_id, requestable_type, requestable_id (polymorphic), type (enum: price_change/
  stock_adjustment/order_cancel/return/reopen_period/...), requested_by, status (pending/
  approved/rejected), approved_by (nullable), reason, created_at, decided_at
```

### Audit log (generik, dipasang via Model Observer, bukan ditulis manual tiap modul)
```
audit_logs
  id, tenant_id, auditable_type, auditable_id, actor_id, action (created/updated/deleted),
  old_values (json), new_values (json), created_at
```

### Akuntansi (lihat `02-modules.md` §18)
```
chart_of_accounts
  id, tenant_id, code, name, type (enum: asset/liability/equity/revenue/expense),
  parent_id (nullable, untuk sub-akun), is_active

journal_entries        -- header, append-only setelah posted (edit = entri koreksi baru)
  id, tenant_id, entry_number (unique per tenant_id), entry_date, accounting_period_id,
  reference_type, reference_id (nullable, polymorphic ke Order/PurchaseOrder/dll kalau
  jurnal ini auto-generated dari transaksi modul lain), memo, status (draft/posted),
  created_by, created_at

journal_lines
  id, tenant_id, journal_entry_id, account_id (FK chart_of_accounts), debit, credit,
  notes

accounting_periods
  id, tenant_id, name (mis. "Agustus 2026"), start_date, end_date,
  status (enum: open/closed/locked), closed_by (nullable), closed_at (nullable)

opening_balances        -- Saldo Awal, satu kali setup per tenant per periode awal
  id, tenant_id, account_id, accounting_period_id, amount (debit positif, credit negatif
  atau kolom debit/credit terpisah — diputuskan saat desain migration Fase 5)
```
`journal_lines` total debit harus sama dengan total credit per `journal_entry_id` —
invariant double-entry ini divalidasi di **Service**, bukan constraint DB literal (sama
pola dengan invariant serial_units↔Stock di atas).

## Prinsip

1. **Append-only untuk histori** (`serial_unit_histories`, `order_status_histories`,
   `audit_logs`, `journal_entries` setelah status `posted`) — tidak pernah
   `UPDATE`/`DELETE`, hanya `INSERT`. Ini yang membuat "scan IMEI/Serial Number → riwayat
   lengkap muncul" bisa diandalkan, dan yang membuat laporan keuangan tidak bisa diam-diam
   diubah setelah periode ditutup.
2. **Status "terkini" adalah cache**, histori adalah kebenaran. Kalau ragu, percaya histori.
3. **`tenant_id` wajib di semua tabel bisnis** (lihat § Konvensi umum di atas dan
   `docs/08-tenancy.md`) — ini keputusan yang membalik draf awal proyek yang sempat
   single-tenant, lihat `docs/00-status.md` #3.
4. Skema detail per tabel (kolom lengkap, index, migration order) baru dirancang saat
   Fase 1 roadmap mulai — dokumen ini adalah kerangka konsep, bukan DDL final.

# Graph Report - .  (2026-08-08)

## Corpus Check
- 17 files · ~25,082 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 122 nodes · 107 edges · 22 communities (12 shown, 10 thin omitted)
- Extraction: 93% EXTRACTED · 7% INFERRED · 0% AMBIGUOUS · INFERRED: 8 edges (avg confidence: 0.84)
- Token cost: 1,200 input · 500 output

## Community Hubs (Navigation)
- Field per halaman (SEMUA yang berhasil diverifikasi)
- Pivot Frontend & Omnichannel Modules
- Akuntansi & Data Model Append-only
- Decision #13: Pulse + Telescope + Reverb dipakai, Octane Ditunda
- SISCOM ERP Reference Product
- DB Transaction & Rollback Rule
- Business Logic — Extracted vs Predicted
- Tenancy Data Model (tenants, tenant_user, branches, warehouses)
- Platform Admin (SaaS-level, Outside Tenant Context)
- Module: IMEI Management
- Modular per Domain Rule
- Decision #7: Laravel Versi Terbaru
- Module: Dashboard
- Queue & Job Architecture
- stock_items Table
- Code Consistency (Actions/Services/DTOs/Enums/Policy)
- Checklist Selesai untuk Layar Baru
- Shared Blade/Livewire Component Set
- Gap Analysis — SISCOM vs Desain Kita
- Form "Edit" (Ubah Data) — Field Inventory
- Field Inventory — Lengkap per Halaman
- SISCOM ERP — Audit Reference (untuk AI coding agent)

## God Nodes (most connected - your core abstractions)
1. `Business Logic — Extracted vs Predicted` - 11 edges
2. `Gap Analysis — SISCOM vs Desain Kita` - 10 edges
3. `Field Inventory — Lengkap per Halaman` - 9 edges
4. `Form "Edit" (Ubah Data) — Field Inventory` - 8 edges
5. `Field per halaman (SEMUA yang berhasil diverifikasi)` - 7 edges
6. `Form "Tambah" (Create) — Field Inventory` - 6 edges
7. `Module: Akuntansi` - 5 edges
8. `Module: IMEI Management` - 4 edges
9. `imeis Table` - 4 edges
10. `Append-only Histori Principle` - 4 edges

## Surprising Connections (you probably didn't know these)
- `Guiding Design Principles (Data Truth, IMEI Truth, Unified Order, Auditability)` --semantically_similar_to--> `Append-only Histori Principle`  [INFERRED] [semantically similar]
  docs/01-vision.md → docs/04-database.md
- `Append-only Histori Principle` --semantically_similar_to--> `Exception per Domain (No Generic Exceptions)`  [INFERRED] [semantically similar]
  docs/04-database.md → docs/05-coding-standards.md
- `Decision #28: Perubahan Template Utama ke Tailwind-Admin (Preline UI)` --references--> `Tech Stack Decision (Laravel + MySQL + Tailwind 4 + Preline UI)`  [EXTRACTED]
  docs/00-status.md → CLAUDE.md
- `Komponen Bersama (Preline UI Kit)` --conceptually_related_to--> `Tech Stack Decision (Laravel + MySQL + Tailwind 4 + Preline UI)`  [EXTRACTED]
  docs/06-ui-ux-guidelines.md → CLAUDE.md
- `Struktur Layout Utama (Sidebar & Header)` --conceptually_related_to--> `Tech Stack Decision (Laravel + MySQL + Tailwind 4 + Preline UI)`  [EXTRACTED]
  docs/06-ui-ux-guidelines.md → CLAUDE.md

## Hyperedges (group relationships)
- **Tenant Isolation Enforcement Mechanism** — docs_08_tenancy_belongs_to_tenant_trait, docs_08_tenancy_context_resolution, docs_04_database_general_conventions, docs_03_architecture_octane [INFERRED 0.85]
- **Mandatory Testing Trio Policy** — docs_05_coding_standards_testing_trio, docs_07_roadmap_fase1, docs_08_tenancy_testing_wajib, docs_00_status_testing_trio_decision [EXTRACTED 0.90]

## Communities (22 total, 10 thin omitted)

### Community 0 - "Field per halaman (SEMUA yang berhasil diverifikasi)"
Cohesion: 0.15
Nodes (12): Akunting, Cara URL "Tambah" ditemukan, Edit form, Field per halaman (SEMUA yang berhasil diverifikasi), Form "Tambah" (Create) — Field Inventory, Halaman dikonfirmasi TIDAK punya form Tambah, Halaman "murni FORM AKSI" (bukan listing+tambah — TIDAK relevan pola ini), Keuangan (+4 more)

### Community 1 - "Pivot Frontend & Omnichannel Modules"
Cohesion: 0.21
Nodes (12): Guiding Design Principles (Data Truth, IMEI Truth, Unified Order, Auditability), Module: Akuntansi, Cross-cutting Feature: Approval Workflow, Cross-cutting Feature: Audit Log, Module: Finance, Module: Report, Akuntansi Tables (chart_of_accounts, journal_entries, journal_lines, accounting_periods, opening_balances), Append-only Histori Principle (+4 more)

### Community 2 - "Akuntansi & Data Model Append-only"
Cohesion: 0.18
Nodes (12): Module: CRM, Module: Garansi (Warranty), Module: IMEI Management, Module: Master Data, Module: Return, Module: Service, imei_histories Table (Append-only), imeis Table (+4 more)

### Community 3 - "Decision #13: Pulse + Telescope + Reverb dipakai, Octane Ditunda"
Cohesion: 0.17
Nodes (11): Aktiva Tetap (Fixed Assets) — **PREDICTED, bukan extracted**, Akuntansi (Jurnal) — `cek()` (EXTRACTED, `siscom_addJournal.html`), Belum ditelusuri (masih banyak fungsi JS lain per halaman yang belum dibaca), Business Logic — Extracted vs Predicted, Pembelian (PI/Faktur Pembelian, edit) — `cekStdHargaBeli` (EXTRACTED, `siscom_edit_pi.html`), Pembelian (Retur/PR) — `cekMinimalQty` (EXTRACTED, `siscom_addPr.html`), Pembelian (RO/Receive) & Persediaan (Adjustment) — `cekDoubleImei` (EXTRACTED), Penjualan (DO/Delivery Order) — `cekStokGudang` & `overHariLimit` (EXTRACTED, `siscom_addDo.html`) (+3 more)

### Community 4 - "SISCOM ERP Reference Product"
Cohesion: 0.18
Nodes (10): 1. Master Data & Inventory (docs/02-modules.md §2-3, §04-database.md), 2. Serial Number Management (docs/02-modules.md §4), 3. Purchasing (docs/02-modules.md §13), 4. Sales / Order Management / POS (docs/02-modules.md §6-7), 5. Finance (docs/02-modules.md §14), 6. Akuntansi (docs/02-modules.md §18) — **gap paling besar**, 7. Multi-Cabang / Organisasi (docs/08-tenancy.md), 8. Audit Log (docs/04-database.md § audit_logs) (+2 more)

### Community 5 - "DB Transaction & Rollback Rule"
Cohesion: 0.18
Nodes (10): Baru dari putaran kedua (submit form filter/cari), Belum tertelusuri (arsitektur AJAX beda, bukan soal data kosong), Cara URL Edit ditemukan (metode BEDA dari form Tambah), Dari putaran pertama (URL edit statis/server-rendered), Error / gagal, Field per halaman (21 yang berhasil diverifikasi, via URL edit REAL), Form "Edit" (Ubah Data) — Field Inventory, Metode lanjutan (setelah user konfirmasi submit form filter/cari diizinkan) (+2 more)

### Community 6 - "Business Logic — Extracted vs Predicted"
Cohesion: 0.20
Nodes (10): Module: Inventory, Module: Marketplace, Marketplace Engine, Module: Order Management, Module: Packing Station, Module: POS Kasir, Module: Purchasing, DB Transaction & Rollback Rule (+2 more)

### Community 7 - "Tenancy Data Model (tenants, tenant_user, branches, warehouses)"
Cohesion: 0.20
Nodes (9): Akunting (Accounting), Field Inventory — Lengkap per Halaman, Help / Tools (diagnostic, prioritas rendah), Keuangan (Finance), Pembelian (Purchasing), Penjualan (Sales), Persediaan (Inventory), Saldo Awal (+1 more)

### Community 8 - "Platform Admin (SaaS-level, Outside Tenant Context)"
Cohesion: 0.33
Nodes (6): User Personas (Kasir, Admin Gudang, Purchasing, CS, Teknisi, Owner, Akuntan, Platform Admin), Module: HR, Module: Setting / User, Belum Masuk Fase Manapun (Mobile App, Multi-marketplace Lanjutan, Platform Admin), Platform Admin (SaaS-level, Outside Tenant Context), Role & Permission per Tenant

### Community 9 - "Module: IMEI Management"
Cohesion: 0.33
Nodes (6): General DB Conventions (InnoDB, utf8mb4, tenant_id, naming), Testing Trio: Unit + Feature/Integration + k6, Fase 1 — Fondasi, BelongsToTenant Trait + Global Scope, Tenant Context Resolution (ResolveTenantContext, TenantContext singleton), Testing Wajib untuk Tenancy (Cross-tenant Isolation)

### Community 10 - "Modular per Domain Rule"
Cohesion: 0.67
Nodes (4): Tech Stack Decision (Laravel + MySQL + Tailwind 4 + Preline UI), Decision #28: Perubahan Template Utama ke Tailwind-Admin (Preline UI), Komponen Bersama (Preline UI Kit), Struktur Layout Utama (Sidebar & Header)

### Community 11 - "Decision #7: Laravel Versi Terbaru"
Cohesion: 0.67
Nodes (3): Multi-tenant SaaS Vision (Current), Single-tenant Vision (Superseded), Kenapa Bukan Database Terpisah per PT

## Knowledge Gaps
- **67 isolated node(s):** `Cara pakai dokumen ini`, `Persediaan (Inventory)`, `Pembelian (Purchasing)`, `Penjualan (Sales)`, `Keuangan (Finance)` (+62 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **10 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Module: IMEI Management` connect `Community 2` to `Community 6`?**
  _High betweenness centrality (0.044) - this node is a cross-community bridge._
- **Why does `Append-only Histori Principle` connect `Community 1` to `Community 2`?**
  _High betweenness centrality (0.035) - this node is a cross-community bridge._
- **What connects `Cara pakai dokumen ini`, `Persediaan (Inventory)`, `Pembelian (Purchasing)` to the rest of the system?**
  _67 weakly-connected nodes found - possible documentation gaps or missing edges._
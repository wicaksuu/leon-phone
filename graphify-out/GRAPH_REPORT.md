# Graph Report - .  (2026-08-07)

## Corpus Check
- 13 files · ~18,095 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 131 nodes · 147 edges · 18 communities (10 shown, 8 thin omitted)
- Extraction: 88% EXTRACTED · 12% INFERRED · 0% AMBIGUOUS · INFERRED: 18 edges (avg confidence: 0.8)
- Token cost: 177,317 input · 0 output

## Community Hubs (Navigation)
- Referensi SISCOM: Dashboard Layout
- Pivot Frontend & Omnichannel Modules
- Akuntansi & Data Model Append-only
- Tenancy Enforcement & Observability Stack
- Vision Pivot: Multi-tenant SaaS
- Error Handling & Transaction Rules
- Referensi SISCOM: Tenant Picker Screen
- Hierarki PT-Cabang-Gudang
- Roles, HR & Platform Admin
- Purnajual Modules
- Modular per Domain Rule
- Laravel Versi Terbaru
- Dashboard Module
- Queue & Job Architecture
- Stock Items Table
- Code Consistency Convention
- UI Checklist Selesai
- Shared UI Components

## God Nodes (most connected - your core abstractions)
1. `SISCOM ERP Retail ERP Dashboard Screenshot` - 25 edges
2. `Utiliti (Utilities) menu item, expanded showing submenu` - 10 edges
3. `Module: Akuntansi` - 8 edges
4. `Decision #12: Balik Full Filament + Livewire (Dibalik dari #6)` - 6 edges
5. `Module: POS Kasir` - 6 edges
6. `Decision #13: Pulse + Telescope + Reverb dipakai, Octane Ditunda` - 5 edges
7. `Module: Packing Station` - 5 edges
8. `Kapan Filament, Kapan Livewire Custom` - 5 edges
9. `imeis Table` - 5 edges
10. `Testing Trio: Unit + Feature/Integration + k6` - 5 edges

## Surprising Connections (you probably didn't know these)
- `Akuntansi (Accounting) menu item` --references--> `Module: Akuntansi`  [INFERRED]
  ref-gambar/WhatsApp Image 2026-08-07 at 16.43.08.jpeg → docs/02-modules.md
- `Decision #11: graphify Sudah Dijalankan Sekali (Usang Sebagian)` --conceptually_related_to--> `LEON PHONE — Retail Management System`  [INFERRED]
  docs/00-status.md → CLAUDE.md
- `Filament+React 2-Agent Split (Reverted Same Day)` --references--> `Decision #12: Balik Full Filament + Livewire (Dibalik dari #6)`  [EXTRACTED]
  CLAUDE.md → docs/00-status.md
- `Exception per Domain (No Generic Exceptions)` --conceptually_related_to--> `Consistent Error Handling Rule`  [INFERRED]
  docs/05-coding-standards.md → CLAUDE.md
- `IMEI as First-Class Entity` --references--> `imeis Table`  [EXTRACTED]
  CLAUDE.md → docs/04-database.md

## Hyperedges (group relationships)
- **Tenant Isolation Enforcement Mechanism** — docs_08_tenancy_belongs_to_tenant_trait, docs_08_tenancy_context_resolution, docs_04_database_general_conventions, docs_03_architecture_octane [INFERRED 0.85]
- **Mandatory Testing Trio Policy** — docs_05_coding_standards_testing_trio, docs_07_roadmap_fase1, docs_08_tenancy_testing_wajib, docs_00_status_testing_trio_decision [EXTRACTED 0.90]
- **Frontend Architecture Pivot (Filament/React Split Reverted)** — docs_00_status_filament_react_split_decision, docs_00_status_full_filament_reversal_decision, docs_03_architecture_filament_vs_livewire, claude_filament_react_split_reverted [EXTRACTED 0.90]

## Communities (18 total, 8 thin omitted)

### Community 0 - "Referensi SISCOM: Dashboard Layout"
Cohesion: 0.11
Nodes (26): Aktivitas Terakhir Anda widget (recent user activity feed/audit log), Akuntansi (Accounting) menu item, Best Seller donut chart widget (top 5 products by quantity), Buka Kunci Data (Unlock Data) submenu item, Dashboard menu item (sidebar, active), SISCOM ERP Retail ERP Dashboard Screenshot, Financial summary cards (Penjualan, Piutang Dagang Outstanding, Pembelian, Hutang Dagang Outstanding) with date-range filter, Ganti Periode (Change Period) submenu item (+18 more)

### Community 1 - "Pivot Frontend & Omnichannel Modules"
Cohesion: 0.17
Nodes (16): Filament+React 2-Agent Split (Reverted Same Day), Tech Stack Decision (Laravel + MariaDB + Filament + Livewire), Decision #6: Filament (Admin) + React/API (Operasional) 2-Agent Split, Decision #12: Balik Full Filament + Livewire (Dibalik dari #6), Decision #2: Database MariaDB, Module: Marketplace, Marketplace Engine, Module: Order Management (+8 more)

### Community 2 - "Akuntansi & Data Model Append-only"
Cohesion: 0.16
Nodes (16): IMEI as First-Class Entity, Guiding Design Principles (Data Truth, IMEI Truth, Unified Order, Auditability), Module: Akuntansi, Cross-cutting Feature: Approval Workflow, Cross-cutting Feature: Audit Log, Module: Finance, Module: Report, Modules/* Folder Structure Convention (+8 more)

### Community 3 - "Tenancy Enforcement & Observability Stack"
Cohesion: 0.16
Nodes (15): Pending Decisions (PHP version, hosting, marketplace priority, payment gateway, thermal printer), Mandatory Tenant Scoping Rule, Mandatory Testing Trio Rule, Decision #13: Pulse + Telescope + Reverb dipakai, Octane Ditunda, Decision #8: Testing Wajib Trio Unit+Feature+k6, Laravel Octane (Deferred — TenantContext Risk), Laravel Pulse (Production Monitoring), Laravel Reverb (WebSocket / Realtime) (+7 more)

### Community 4 - "Vision Pivot: Multi-tenant SaaS"
Cohesion: 0.14
Nodes (15): LEON PHONE — Retail Management System, Multi-tenant SaaS Architecture, Dashboard Screenshot (WhatsApp Image 2026-08-07 16.43.08), Pilih PT Screenshot (WhatsApp Image 2026-08-07 16.47.07), Shared Database + tenant_id Isolation, SISCOM ERP Reference Product, Modern/Premium/Responsive UI Rule, Decision #5: Modul Akuntansi Ditambahkan (+7 more)

### Community 5 - "Error Handling & Transaction Rules"
Cohesion: 0.25
Nodes (8): Consistent Error Handling Rule, Decision #9: Error Handling & DB Rollback Prioritas Eksplisit, Module: Inventory, Module: Purchasing, Error Handling & Transaction Design (Service Layer), DB Transaction & Rollback Rule, Exception per Domain (No Generic Exceptions), Fase 2 — Operasional Inti

### Community 6 - "Referensi SISCOM: Tenant Picker Screen"
Cohesion: 0.25
Nodes (8): Per-company database card UI pattern: logo, company name, PT legal name, industry tag, user count, branch count, "Login Database" button, register/subscription status badge, Database/tenant picker screen pattern: after login, user picks which PT (company database) to enter, Card: "enamjalan" / PT. Enam Jalan Dewa Elektronik, Retail, 5 users, 1 branch, REGISTER: EXPIRED 09/12/2026, Card: "leon" / Leon Sellular Indonesia, Retail, 9 users, 1 branch, REGISTER: EXPIRED 09/12/2026, Inference: "Leon Sellular Indonesia" card plausibly represents the real client whose retail operation this project (SAAS POS LEON PHONE) targets, currently running on SISCOM ERP, SISCOM ERP (competitor retail ERP platform, myapp.siscom.id), Subscription/register status badge on card (e.g. "REGISTER: EXPIRED 09/12/2026", shown in green), SISCOM ERP "Database" picker screen (post-login, choose PT) screenshot

### Community 7 - "Hierarki PT-Cabang-Gudang"
Cohesion: 0.29
Nodes (7): PT → Cabang → Gudang Hierarchy, Decision #4: Hierarki Lokasi PT → Cabang → Gudang, Decision #1: RMS, bukan sekadar POS, RMS, bukan POS, Module: Master Data, Tenancy & Lokasi Tables (tenants, tenant_user, branches, warehouses), Tenancy Data Model (tenants, tenant_user, branches, warehouses)

### Community 8 - "Roles, HR & Platform Admin"
Cohesion: 0.33
Nodes (6): User Personas (Kasir, Admin Gudang, Purchasing, CS, Teknisi, Owner, Akuntan, Platform Admin), Module: HR, Module: Setting / User, Belum Masuk Fase Manapun (Mobile App, Multi-marketplace Lanjutan, Platform Admin), Platform Admin (SaaS-level, Outside Tenant Context), Role & Permission per Tenant

### Community 9 - "Purnajual Modules"
Cohesion: 0.40
Nodes (6): Module: CRM, Module: Garansi (Warranty), Module: IMEI Management, Module: Return, Module: Service, Fase 4 — Purnajual

## Knowledge Gaps
- **36 isolated node(s):** `Multi-tenant SaaS Architecture`, `Pending Decisions (PHP version, hosting, marketplace priority, payment gateway, thermal printer)`, `Pilih PT Screenshot (WhatsApp Image 2026-08-07 16.47.07)`, `RMS, bukan POS`, `User Personas (Kasir, Admin Gudang, Purchasing, CS, Teknisi, Owner, Akuntan, Platform Admin)` (+31 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **8 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Module: Akuntansi` connect `Akuntansi & Data Model Append-only` to `Referensi SISCOM: Dashboard Layout`, `Vision Pivot: Multi-tenant SaaS`?**
  _High betweenness centrality (0.405) - this node is a cross-community bridge._
- **Why does `imeis Table` connect `Akuntansi & Data Model Append-only` to `Purnajual Modules`, `Hierarki PT-Cabang-Gudang`?**
  _High betweenness centrality (0.347) - this node is a cross-community bridge._
- **Why does `Module: IMEI Management` connect `Purnajual Modules` to `Pivot Frontend & Omnichannel Modules`, `Akuntansi & Data Model Append-only`?**
  _High betweenness centrality (0.305) - this node is a cross-community bridge._
- **What connects `Multi-tenant SaaS Architecture`, `Pending Decisions (PHP version, hosting, marketplace priority, payment gateway, thermal printer)`, `Pilih PT Screenshot (WhatsApp Image 2026-08-07 16.47.07)` to the rest of the system?**
  _36 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Referensi SISCOM: Dashboard Layout` be split into smaller, more focused modules?**
  _Cohesion score 0.11384615384615385 - nodes in this community are weakly interconnected._
- **Should `Vision Pivot: Multi-tenant SaaS` be split into smaller, more focused modules?**
  _Cohesion score 0.14285714285714285 - nodes in this community are weakly interconnected._
# Gap Analysis — SISCOM vs Desain Kita

> Jawaban langsung untuk "sudah 100% sama atau belum": **BELUM**. Desain kita
> (`docs/02-modules.md` + `docs/04-database.md`) benar secara STRUKTUR/ALUR besar, tapi
> jauh lebih SEDERHANA dari SISCOM di level field/kolom — wajar, karena dokumen kita masih
> blueprint (belum pernah ada implementasi nyata dites di lapangan seperti SISCOM yang
> sudah dipakai production sejak lama). Gap di bawah BUKAN daftar "harus semua diikuti" —
> ini bahan diskusi prioritas mana yang perlu diadopsi vs disederhanakan tetap.

Legenda: ✅ = konsep sudah ada di desain kita (detail field boleh beda) · ⚠️ = ada tapi
lebih sederhana dari SISCOM (gap sebagian) · ❌ = konsep TIDAK ADA sama sekali di desain kita saat ini.

## 1. Master Data & Inventory (docs/02-modules.md §2-3, §04-database.md)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| Kategori (Kelompok Barang) py Kode Pajak sendiri | ❌ | Kita belum ada konsep pajak per-kategori sama sekali |
| Produk py flag POS (boleh dijual di kasir atau tidak) | ❌ | Gap kecil, mudah ditambah |
| Produk py Fast/Slow/Dead Moving (%) per-item | ❌ | `docs/02-modules.md` §16 baru sebut laporan aging, belum threshold per-produk |
| Produk py flag Perolehan Poin (CRM loyalty per-item) | ⚠️ | CRM kita baru "point" secara umum, belum per-produk |
| Riwayat harga per **Kelompok Std Harga Jual** (bukan 1 harga jual tunggal) | ⚠️ | `docs/02-modules.md` fitur "Riwayat Harga" ada, tapi belum ada konsep multi-tier price group |
| Bundling produk (Link Stock + Pilih Barang) | ❌ | Tidak ada di desain kita |
| **Tracking = 1 flag gabungan** (Serial/IMEI vs tidak) | ✅ | **Sudah kita ikuti** — `docs/00-status.md` #18/#20, `identifier_value` polos |
| **Gudang py Alamat2, Otorisasi (akses)** | ⚠️ | Kita baru 1 alamat, belum ada per-gudang access control |
| **Status barang (rusak/service) = GUDANG FISIK terpisah**, bukan status flag | ⚠️ | Kita pakai `current_status` enum (`docs/04-database.md`) — SISCOM pakai lokasi. Worth didiskusikan (lihat catatan di temuan sebelumnya) |
| Transfer Gudang/Sementara py kolom **Accounting** (dampak jurnal) | ❌ | Mutasi kita didesain murni fisik, tidak terhubung Akuntansi |
| **2 jenis transfer**: permanen vs "Sementara" (bisa dibalik) | ❌ | Kita cuma 1 jenis mutasi |
| Penyesuaian Persediaan py **Harga Netto** (nilai uang) + Accounting | ⚠️ | Kita belum eksplisit stock adjustment py dampak nilai uang/jurnal |
| Cetak Barcode py TEMPLATE label custom (ukuran kertas, posisi baris) | ❌ | Kita baru sebut "cetak barcode" sebagai fitur, belum ada config template |
| Modul Perakitan (Bahan Baku → Barang Jadi) | ❌ | Tidak ada di desain kita — kandidat fitur masa depan, bukan prioritas |

## 2. Serial Number Management (docs/02-modules.md §4)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| Field lookup namanya generik **"S/N"** | ✅ | Sudah diikuti — istilah kita juga generalisasi |
| Kroscek IMEI (tool validasi terpisah) | ❌ | Tool diagnostik, prioritas rendah — bukan modul utama |

## 3. Purchasing (docs/02-modules.md §13)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| PR & PO masing-masing py aksi **"Tutup" eksplisit** (partial fulfillment) | ❌ | Desain kita linear tanpa status "closed"/partial — **gap penting**, alur nyata jarang 100% simple linear |
| **Receive (Nota Penerimaan) TERPISAH dari Invoice (Faktur Pembelian)** — 3-way matching | ⚠️ | `docs/02-modules.md` sebut "Receive → Invoice Supplier" berurutan, tapi belum eksplisit sebagai 2 dokumen independen dengan lag waktu |
| Supplier py **Npwp, Limit Hutang, Uang Muka, Batas** | ⚠️ | Master Data kita baru Supplier basic, belum credit management |
| Supplier bisa "CASH USER" / marketplace (Blibli) / fintech (Akulaku) sbg entitas | ⚠️ | Kita asumsikan supplier selalu B2B formal — perlu fleksibilitas |
| Faktur Pembelian py kolom **Ppn** eksplisit | ⚠️ | Pajak belum eksplisit di skema `orders`/purchasing kita |
| Retur Pembelian = modul/tabel terpisah | ✅ | Sudah selaras, `docs/02-modules.md` §9 Return sudah cover baik utk pembelian maupun penjualan |

## 4. Sales / Order Management / POS (docs/02-modules.md §6-7)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| Alur B2B lengkap: **Penawaran(Quote) → SO → DO → Invoice**, simetris dgn Purchasing | ⚠️ | Kita cuma py Order Management generik, belum pisah tahap Quote |
| SO py aksi **"Tutup"** juga (sama seperti PO) | ❌ | Sama gap dgn Purchasing |
| Customer py **Limit, Piutang, Uang Muka, Sisa Limit** (simetris Supplier) | ⚠️ | CRM kita belum py credit management customer |
| **POS py "No. Meja"** (nomor meja/antrian) | ❌ | Tidak ada di desain kita — mungkin tidak relevan utk retail HP (lebih cocok F&B), tapi worth ditanya |
| **POS py mode "Cek Harga"** (scan tanpa checkout) | ❌ | Fitur kecil tapi berguna, tidak ada di desain kita |
| **POS py "saldokas"** (cash drawer balance) | ❌ | Kita belum desain cash drawer/shift kasir |
| **POS py void dengan alasan (ketvoid)** | ❌ | Kita belum desain pembatalan transaksi POS dgn reason wajib |
| **POS py tombol e-Faktur langsung** | ❌ | Lihat baris E-Faktur di bawah |
| **E-Faktur (Faktur Pajak elektronik DJP)** | ❌ | **GAP BESAR** — sama sekali tidak ada di `docs/02-modules.md`. Perlu ditanyakan ke user: apakah tenant kita PKP dan wajib e-Faktur? |
| Faktur Penjualan py "Wilayah" (bukan Kel.Pelanggan) | ⚠️ | Dimensi laporan tambahan yang kita belum punya |

## 5. Finance (docs/02-modules.md §14)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| **Tiap Tipe Bayar mapping ke 5 akun COA berbeda** (Acno/Achtg/Acptg/Aclsk/Acrsk) | ❌ | Kita belum desain integrasi payment-method↔COA sedetail ini |
| Bank py mapping akun (Acno/Acdb/Ackr/Accr/Acbatal) | ❌ | sama pola |
| **Cheque/Giro py lifecycle sendiri** (Tolak, Batal, jatuh tempo) | ❌ | Tidak ada di desain kita — kalau tenant transaksi giro, ini gap penting |
| Hutang/Piutang py alur **Tanda Terima/Nota Tagihan → Uang Muka → Pembayaran/Penerimaan** (3 tahap terpisah) | ⚠️ | Kita baru sebut "Hutang Supplier/Piutang Customer" generik, belum breakdown 3-tahap |
| AP/AR py **Laporan Umur Hutang/Piutang** (Aging) built-in | ✅ | Konsep sudah ada di `docs/02-modules.md` §16 Report |

## 6. Akuntansi (docs/02-modules.md §18) — **gap paling besar**

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| COA py **6 segmen kode (AC1-AC6)** + Level + H/D hierarkis | ⚠️ | Skema kita (`docs/04-database.md`) COA masih flat (code, name, parent_id) — jauh lebih sederhana |
| COA terhubung ke **Cost Centre** | ❌ | Dimensi Cost Centre TIDAK ADA di desain kita sama sekali |
| **Aktiva Tetap (Fixed Assets) + Depresiasi** — modul lengkap dgn 10 aset aktif di data riil | ❌ | **GAP BESAR** — sama sekali tidak ada di `docs/02-modules.md`/`docs/04-database.md` |
| **Recurring Journal** (jurnal berulang otomatis) | ❌ | Tidak ada di desain kita |
| **Jurnal Posting sbg aksi terpisah** (draft → posted eksplisit) | ✅ | Sudah selaras — `docs/04-database.md` journal_entries py status draft/posted |
| Form Neraca/Laba-Rugi/Arus Kas/Perubahan Modal (4 laporan keuangan formal) | ⚠️ | Kita baru sebut "Neraca, Laba/Rugi, Arus Kas" di §16 Report, belum "Perubahan Modal" |
| **Saldo Awal py 4 kategori**: Persediaan Barang, Hutang, Piutang, Neraca (bukan cuma akun) | ⚠️ | `docs/04-database.md` `opening_balances` cuma cover akun COA, belum opening STOK/AP/AR terpisah |

## 7. Multi-Cabang / Organisasi (docs/08-tenancy.md)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| **"GROUP CABANG"** — level di atas Cabang | ❌ | Hierarki kita cuma PT→Cabang→Gudang, tidak ada grouping Cabang |
| NPWP di level Cabang (bukan cuma Tenant) | ❌ | Kita belum desain NPWP sama sekali (baik di Tenant maupun Cabang) |
| User py "Level" + **Jumlah Menu** (akses granular per-menu) | ⚠️ | `docs/08-tenancy.md` role per-tenant sudah ada, tapi belum granular per-menu individual |
| **"Tutup Buku" (year-end) TERPISAH dari "Tutup Periode" (month-end)** | ⚠️ | `docs/02-modules.md` §18 baru sebut "Tutup Periode" generik, belum ada 2-level closing |

## 8. Audit Log (docs/04-database.md § audit_logs)

| Temuan SISCOM | Status | Catatan |
|---|---|---|
| Log py **Log IP** (alamat IP) | ❌ | Skema `audit_logs` kita belum ada kolom IP |
| "Laporan Hapus Data" — audit KHUSUS untuk penghapusan | ⚠️ | `action=deleted` sudah cover ini secara konsep, tapi SISCOM punya laporan dedicated |

## Ringkasan prioritas (rekomendasi, bukan keputusan final)

**Gap yang PALING layak diadopsi duluan** (dampak besar, effort masuk akal):
1. Status "Tutup" eksplisit untuk PR/PO/SO (partial fulfillment) — pola berulang di 3 tempat
2. E-Faktur — kalau tenant PKP, ini bukan opsional
3. Aktiva Tetap (Fixed Assets) — modul Akuntansi kita jelas kurang tanpa ini
4. Cost Centre sebagai dimensi tambahan di COA
5. Credit limit management (Supplier & Customer simetris)

**Gap yang BISA ditunda** (fitur niche/SISCOM-spesifik, belum tentu relevan bisnis kita):
- Cheque/Giro lifecycle (kalau tenant tidak pakai giro)
- Perakitan/Assembly (kalau tidak ada proses rakit)
- No. Meja di POS (kemungkinan sisa dari template F&B SISCOM, tidak relevan HP)
- Recurring Journal

> **UPDATE (`docs/00-status.md` #26)**: keputusan final user BUKAN adopsi selektif seperti
> kerangka "prioritas" di atas — user memutuskan **replikasi fitur penuh** ("copas
> sistemnya... semua fitur sama dengan yang lama/SISCOM"), UI/UX saja yang dimodernkan.
> Semua gap ❌/⚠️ di atas **sudah diserap** ke `docs/02-modules.md` dan `docs/04-database.md`
> (per modul, bukan per-baris — cek langsung ke dokumen itu untuk detail final). Section
> "Ringkasan prioritas" di atas jadi **historis** (menunjukkan urutan berpikir sebelum
> keputusan final), bukan panduan aktif lagi — jangan pakai buat memutuskan skip fitur.

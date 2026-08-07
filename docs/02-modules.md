# 02 — Modules

> **Pivot besar** (`docs/00-status.md` #26): struktur modul di bawah ini **mengikuti
> struktur SISCOM ERP langsung** (hasil audit lengkap di `docs/siscom-reference/`), bukan
> abstraksi 18-modul buatan sendiri seperti draf sebelumnya. Keputusan user: **"bukan
> adopsi selektif, tapi copas sistemnya dengan tampilan lebih fresh — semua fitur sama
> dengan yang lama (SISCOM)"**. Detail field per halaman/form → 4 dokumen di
> `docs/siscom-reference/` (`01-field-inventory.md` listing, `03-add-form-fields.md`
> Tambah, `04-edit-form-fields.md` Edit, `02-gap-analysis.md` perbandingan). Dokumen ini
> adalah RINGKASAN terstruktur dari semua itu — kalau butuh detail field persis, rujuk
> balik ke `docs/siscom-reference/`.
>
> Modul di-organisir persis sidebar SISCOM: **Dashboard, Persediaan, Pembelian, Penjualan,
> Keuangan, Akuntansi, Utiliti, Saldo Awal, Help**. Ditambah beberapa modul **omnichannel
> milik Leon Phone sendiri** (Marketplace, POS Kasir, Packing Station) yang TIDAK ada di
> SISCOM tapi memang jadi kebutuhan operasional toko ini (lihat § "Tambahan Leon Phone" di
> bagian bawah) — bukan pengurangan dari SISCOM, murni penambahan di luar cakupan yang
> diaudit.

## 0. Dashboard
Kartu info perusahaan · Feed aktivitas/audit log · Chart best seller · Ringkasan
Penjualan/Piutang/Pembelian/Hutang · Chart Pembayaran Hutang vs Piutang · Chart Laba/Rugi.
(Referensi visual: `ref-gambar/WhatsApp Image 2026-08-07 at 16.43.08.jpeg`.)

## 1. Persediaan (Inventory)

### Master Data
- **Master Barang** — Kode, Group, Inisial, Nama, Barcode, Tipe, Satuan, harga
  (Standar Jual/Min Jual), Min/Max Stok, **Jenis**, **Multi Satuan** (konversi unit, mis. 1
  box = 12 pcs — barang bisa punya >1 satuan dgn rasio konversi), **Tracking** (flag
  unit-level: barang ini dilacak per-unit via S/N/IMEI atau cuma agregat qty — SISCOM TIDAK
  membedakan IMEI vs Serial Number sbg 2 tipe berbeda, cuma 1 flag "tracked" vs tidak, lihat
  `docs/siscom-reference/01-field-inventory.md`), flag **POS** (boleh dijual di kasir),
  **Fast/Slow/Dead Moving** threshold per-item, flag **Perolehan Poin** (CRM loyalty
  per-item), scan barcode langsung di form.
- **Kelompok Barang** — hierarkis (**Detail Header** = flag header/parent kategori), py
  **Kode Pajak sendiri** (pajak per-kategori), 2 kode inisial (utk konteks tampilan
  berbeda: struk vs laporan).
- **Merek/Brand**, **Satuan** (py Kode Pajak juga), **Ukuran/Size** — master sederhana.
- **Kelompok Std Harga Jual** — multi-tier pricing, Customer/Kelompok Pelanggan bisa
  ditempel ke tier tertentu.
- **Master Gudang** — Kode, **Otorisasi** (wajib, akses per-gudang — access control
  granular per gudang, bukan cuma per cabang), Lokasi, Lokasi 2, Group.
- **Bahan Baku** & **Bahan Jadi** — master data pendukung modul Perakitan (Bahan Baku →
  Barang Jadi, lihat §Perakitan di bawah).

### Transaksi Stok
- **Stok Opname** — per Kelompok Barang (bisa per-kategori, tidak harus semua barang
  sekaligus), **Diopname oleh** (siapa yg hitung fisik) → sistem hitung selisih vs data
  tercatat → approval sebelum selisih benar-benar mengubah stok.
- **Transfer Gudang** — permanen, Gudang Dari/Ke eksplisit, **Pilih TS** (tipe transfer),
  py kolom **Accounting** (dampak jurnal — mutasi fisik terhubung ke Akuntansi, bukan
  murni fisik).
- **Transfer Sementara** — **2 jenis transfer berbeda** dari Transfer Gudang biasa: bisa
  DIBALIK (reversible), dipakai utk kasus barang dipinjam/dicoba dulu antar gudang.
- **Penyesuaian Persediaan (Stock Adjustment)** — Nomor Faktur, **Penyesuaian** (jenis
  penyesuaian), **listimei** (adjust per-unit S/N spesifik, bukan cuma per-qty), **Harga
  Netto** (nilai uang, py dampak Accounting), rentang tanggal.
- **Saldo Awal Persediaan Barang** — opening stock per SUPPLIER (bukan cuma per akun COA),
  bagian dari § Saldo Awal (lihat §7).

### Perakitan (Assembly) — fitur niche, prioritas rendah
Bahan Baku → Barang Jadi via formula/BOM (`editFormulaForm` terhubung ke Master Barang).
Kandidat fitur masa depan, kemungkinan **tidak relevan untuk retail HP** (Leon Phone tidak
merakit barang) — pertimbangkan skip di implementasi awal.

### Cetak Barcode
Print label barcode/QR dgn **template custom** (ukuran kertas, posisi baris) — bukan cuma
fitur "cetak", ada konfigurasi template.

## 2. Pembelian (Purchasing)

Alur formal lengkap (simetris dgn Penjualan §3), tiap tahap dokumen TERPISAH — SISCOM
support **3-way matching** (Receive independen dari Invoice, bisa beda waktu):
```
Surat Permintaan Barang (PQ) → Purchase Order (PO) → Nota Penerimaan Barang/Receive (RO)
  → Faktur Pembelian/Invoice (PI) → Pembayaran (AP Payment)
```
- **PQ** (`addPq`) — No. Faktur, Cabang, **cekppn**, Pilih Barang.
- **PO** — py aksi **"Tutup" eksplisit** (partial fulfillment — PO tidak harus selalu
  diterima 100% sekaligus, bisa ditutup manual kalau sisa qty tidak akan dikirim lagi).
- **RO/Receive** (`addRo`) — Supplier, **cekppn**, widget kalender bulan (jadwal
  cicilan/termin), independen dari Invoice.
- **PI/Faktur Pembelian** (`editPiForm`) — Nomor Faktur, Cabang, Referensi, Hari/Jatuh
  Tempo, **Pilih Data**, Supplier, kalender bulan+tahun, **cekppn**, Pilih Barang.
- **Retur Pembelian (PR)** — wajib **Berdasarkan** (retur SELALU merujuk transaksi asal
  spesifik, bukan retur bebas).
- Supplier py **NPWP, Limit Hutang, Uang Muka, Batas** (credit management), bisa berstatus
  "CASH USER" / marketplace (Blibli) / fintech (Akulaku) sbg entitas — bukan selalu B2B
  formal.
- **Kelompok Supplier** — Kode, Status, Inisial, Tipe.

⚠️ **Temuan penting dari live audit**: tenant "leon" (data produksi asli) belum pernah
pakai PQ/PO/RO/PR sama sekali — cuma langsung PI (lihat
`docs/siscom-reference/04-edit-form-fields.md` § Terkonfirmasi Kosong). Tetap bangun alur
lengkapnya (SISCOM py fitur ini, requirement "fitur sama dgn yang lama"), tapi jangan
heran kalau di data riil nanti PQ/PO/RO jarang dipakai — PI-langsung sepertinya alur yang
paling sering dipraktikkan.

## 3. Penjualan (Sales)

Alur formal simetris Pembelian:
```
Penawaran/Quote (SQ) → Order Penjualan (SO) → Delivery Order (DO) → Faktur Penjualan (SI)
```
- **SQ** — dokumen penawaran awal.
- **SO** (`addSo`) — **Pilih SQ** (link eksplisit ke Quote asal — SO diturunkan dari Quote
  via referensi nyata, bukan cuma alur konseptual), Discount, **PPN (%)**, Ongkos, Netto —
  breakdown pajak/ongkos/diskon lengkap saat create. Py aksi **"Tutup"** juga (partial
  fulfillment, sama pola dgn PO).
- **DO (Delivery Order)** — **field `listimei`/`tempflagimei`** — **KONFIRMASI PENTING**:
  scan S/N/IMEI terjadi di tahap DO (packing/pengiriman), **BUKAN** di tahap Invoice. Ini
  cocok dgn desain kita soal Packing Station scan-unit-saat-packing (lihat § Tambahan Leon
  Phone).
- **SI/Faktur Penjualan** (`editSiForm`) — Nomor Faktur, Cabang, Pelanggan, **Salesman**,
  Referensi, Hari/Jatuh Tempo, `nopj` (no. PO customer referensi), `noseri`, **Pilih
  Data**, widget kalender bulan+tahun (termin pembayaran).
- **Retur Penjualan (SR)** — wajib **Berdasarkan** + **Pilih Faktur SI** (retur selalu
  merujuk invoice asal spesifik), py field `listimei` (retur per-unit S/N juga), Salesman.
- Customer py **Limit, Piutang, Uang Muka, Sisa Limit** (credit management, simetris
  Supplier), **Kelompok Harga** (assign ke tier pricing), **Kelompok \*** + **Sales \***
  wajib saat edit.
- **Kelompok Pelanggan** — Kode, Status, Inisial, Tipe.
- **Salesman** — master data terpisah, py flag **Non Sales** (bisa ditandai "bukan sales
  aktif" tanpa dihapus), assign ke Cabang.
- **Promo** — master data promosi (belum diaudit detail field-nya, prioritas rendah,
  tenant "leon" belum pernah pakai).
- Faktur Penjualan py dimensi **"Wilayah"** (bukan cuma Kelompok Pelanggan) utk laporan.
- **E-Faktur (Faktur Pajak elektronik DJP)** — tombol langsung dari POS/SI. **Perlu
  dikonfirmasi ke user**: apakah tenant Leon Phone PKP dan wajib e-Faktur? Kalau ya, ini
  BUKAN opsional.

⚠️ Sama seperti Pembelian: tenant "leon" belum pernah pakai SQ/SO/DO — cuma langsung SI.
Bangun alur lengkapnya tetap, tapi ekspektasikan pemakaian nyata condong ke SI-langsung.

## 4. Keuangan (Finance)

- **Uang Muka Pembelian (AP Down Payment)** / **Uang Muka Penjualan (AR Down Payment)** —
  dokumen terpisah dari Payment/Receipt biasa.
- **Pembayaran Hutang (AP Payment)** — Voucher, Cabang, Supplier, No. Faktur (pilih faktur
  yg dibayar), **integrasi Giro langsung di form ini** (`gironormalTemp`/`tglgiroTemp`/
  `nominalgiroTemp`) — bukan modul terpisah yg harus dibuka manual.
- **Penerimaan Piutang (AR Receipt)** — sama pola dgn AP Payment, plus `ketgiro1Temp`.
- **Faktur Piutang (AR Invoice)** — link eksplisit ke Faktur Penjualan asal.
- Alur Hutang/Piutang **3-tahap**: Tanda Terima/Nota Tagihan → Uang Muka → Pembayaran/
  Penerimaan — bukan 1 tahap generik "bayar hutang".
- **Penerimaan Kas/Bank** / **Pengeluaran Kas/Bank** — Voucher, **Kode Akun**, Detail
  MULTI-BARIS (bisa split 1 voucher ke beberapa akun COA sekaligus).
- **Tipe Bayar** — py **5 mapping akun COA berbeda per tipe bayar** (Acno/Achtg/Acptg/
  Aclsk/Acrsk), flag **POS** (boleh dipakai di kasir), flag **Kartu** (kredit/debit),
  flag **Uang Muka**.
- **Bank** — py mapping akun sendiri (Acno/Acdb/Ackr/Accr/Acbatal).
- **Transaksi Bank** — terhubung langsung ke modul Cheque/Giro (**Pilih Giro** wajib).
- **Cheque/Giro** — **lifecycle module sendiri** (Tolak, Batal, jatuh tempo) — kalau
  tenant Leon Phone transaksi giro, ini bukan fitur niche yg bisa diskip. **Perlu
  dikonfirmasi ke user**: apakah Leon Phone pakai giro dalam operasional?
- **Laporan Umur Hutang/Piutang (Aging)** built-in.

⚠️ Tenant "leon" belum pernah pakai modul ini sama sekali (AP/AR Down Payment, Cash/Bank,
Cheque/Giro semua 0 data) — bangun tetap sesuai spec SISCOM, tapi ini kemungkinan modul yg
paling belakangan dipakai serius di operasional nyata.

## 5. Akuntansi

- **Chart of Accounts (COA)** — **HIERARKIS 6-SEGMEN** (Level 1-6, kolom `as1`-`as6`,
  "Pilih Akun" per level) — **bukan flat code+parent_id**. Py **Cost Centre wajib** per
  akun, **Anggaran/Thn** (budget tahunan terintegrasi langsung ke COA, bukan modul
  terpisah).
- **Cost Centre** — dimensi tambahan, dipakai di COA & transaksi.
- **Jurnal Manual** — Voucher, grid multi-baris debit/kredit, **validasi real-time
  `selisih`** (debit-kredit harus 0 sebelum submit).
- **Jurnal otomatis** dari transaksi modul lain (penjualan → jurnal penjualan, dst,
  event-driven).
- **General Ledger (Buku Besar)** — **murni view/report otomatis** dari posting jurnal,
  **TIDAK ADA create manual** (dikonfirmasi: `addGl` 404, tidak ada endpoint-nya).
- **Aktiva Tetap (Fixed Assets)** — modul lengkap: **Periode Susut**, **Penyusutan
  (Berapa Bulan)**, **Nilai Buku**, **Posting [DR]/[CR]** — **depresiasi OTOMATIS
  terjadwal**, bukan jurnal manual tiap bulan.
- **Recurring** (`addRe`) — field-nya HAMPIR IDENTIK dgn Fixed Assets (Periode Susut,
  Penyusutan, Nilai Buku, Posting DR/CR) — kemungkinan Recurring Journal
  diimplementasikan sbg varian mesin depresiasi/posting terjadwal yg sama, bukan modul
  jurnal berulang generik terpisah.
- **Tutup Buku (year-end)** — **TERPISAH** dari **Tutup Periode (month-end)**, 2-level
  closing.
- Laporan formal: Neraca, Laba/Rugi, Arus Kas, **Perubahan Modal** (4 laporan, bukan 3).

⚠️ Modul Akunting terkonfirmasi **KOSONG total** di tenant "leon" (COA/Journal/Fixed
Assets punya STRUKTUR yg terbukti dari form, tapi 0 record riil kecuali Fixed Assets yg
py 1 entri) — kemungkinan besar tenant ini belum resmi mulai pembukuan double-entry lewat
sistem ini. Bangun modul lengkap sesuai spec, siapkan untuk saat tenant mulai pakai.

## 6. Utiliti

- **Setting Cabang** — Kode, Alamat, Telp, FAX, **NPWP di level Cabang** (bukan cuma
  Tenant/PT).
- **Setting Default**, **Setting Password (User Management)** — user py assignment
  eksplisit ke Cabang+Gudang tertentu, **Default Printer Struk**.
- **Setting Menu User** — akses granular PER-MENU individual (bukan cuma role generik).
- **Maintenance Data**, **Ganti Periode**, **Tutup Periode**, **Buka Kunci Data** (butuh
  approval workflow — kesalahan di sini bisa merusak laporan keuangan terlaporkan),
  **Validasi Data** (cek konsistensi saldo sebelum tutup periode).
- **"GROUP CABANG"** — level hierarki DI ATAS Cabang (grouping cabang, mis. utk laporan
  konsolidasi regional) — konsep yg tidak ada di hierarki PT→Cabang→Gudang kita saat ini.
- Log py **Log IP** (alamat IP tercatat di audit log).

## 7. Saldo Awal

**4 kategori terpisah** (bukan cuma "saldo akun"): Persediaan Barang (per Supplier),
Hutang, Piutang, Neraca (akun COA) — setup sekali per tenant per periode awal.

## 8. Help / Tools

Kroscek IMEI (tool validasi terpisah, prioritas rendah), Min Stock Form, Journal Check,
HPP Stock, Error Cross Check, Update Stock Formula, AC Setting/Analysis Setting, S/N
Status Report — kumpulan utility/diagnostic tool, bukan modul bisnis utama.

---

## Tambahan Leon Phone (di luar cakupan SISCOM yang diaudit)

Modul berikut **TIDAK ada** di SISCOM (tenant "leon" yang diaudit tidak menunjukkan
menu ini), tapi tetap dibangun karena kebutuhan operasional nyata Leon Phone sbg retailer
omnichannel (lihat `CLAUDE.md`):

- **Marketplace Engine** — Shopee/Tokopedia/TikTok/Lazada/Blibli masuk lewat satu engine
  dgn adapter per-marketplace sebelum jadi Order (lihat `03-architecture.md` §
  Marketplace Engine).
- **POS Kasir** — layar transaksi offline custom Livewire (SISCOM py flag "POS" di Tipe
  Bayar/Master Barang yg mengindikasikan ada konsep kasir, tapi halaman transaksi POS
  itu sendiri tidak masuk cakupan audit — kemungkinan modul terpisah yg tidak dibuka).
- **Packing Station** — scan unit S/N/IMEI saat packing (selaras dgn temuan `listimei` di
  DO SISCOM — validasi ini KONSISTEN dgn pola SISCOM sendiri, cuma kita buat jadi layar
  dedicated).
- **Return/Warranty/Service/CRM sbg modul customer-facing terpisah** — SISCOM py Retur
  Pembelian/Penjualan sbg dokumen transaksi, tapi tidak py modul Garansi/Servis/CRM
  loyalty terpisah yg teraudit — ini murni tambahan Leon Phone.

## Serial Number / Unit Tracking (konsep lintas-modul)

Bukan modul sendiri, tapi **entitas dengan histori penuh** yg dipakai lintas Persediaan,
Penjualan (DO, SR), Purnajual (Return/Warranty/Service):
```
Unit (S/N atau IMEI) → Supplier → Tanggal Masuk → Gudang → [Marketplace] → Order/DO
  → Customer → Garansi → Retur
```
Detail struktur data → `04-database.md`. Barang **tanpa** identifier individual
(aksesoris) tetap dilacak agregat via `stock_items`.

---

## Fitur lintas-modul (wajib ada di semua modul relevan)

- **Audit Log** — siapa, kapan, apa yang berubah (before/after), **py Log IP**.
- **Approval Workflow** — perubahan harga, pembatalan transaksi, retur, stock adjustment,
  buka kunci periode. **Temuan dari extract logic JS SISCOM asli**
  (`docs/siscom-reference/05-business-logic.md` § Pola Approval): SISCOM pakai **step-up
  authorization SINKRON** (supervisor login on-the-spot lewat modal password terpisah,
  transaksi lanjut seketika), BUKAN antrian approval async spt `approval_requests` di
  `04-database.md`. **Perlu diputuskan user** sebelum Fase 1 selesai: ikut pola sync
  SISCOM, tetap pakai pola async kita, atau dukung dua-duanya (sync utk gate real-time
  spt harga di POS/kasir, async utk yg wajar ditunda spt buka kunci periode).
- **Riwayat Harga** — histori harga beli & harga jual per produk/varian.
- **Label Barcode & QR Code** — cetak label dgn template custom (ukuran kertas, posisi).
- **Import/Export Excel** — master data, stok, transaksi.
- **Attachment** — faktur supplier, foto retur, bukti transfer.
- **Notification Center** — stok minimum, order baru, gagal sinkronisasi marketplace.
- **Backup & Restore** — database + file aplikasi.

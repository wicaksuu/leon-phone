# Form "Tambah" (Create) — Field Inventory

> **Status: SEMUA URL "Tambah" YANG TERIDENTIFIKASI SUDAH DIVERIFIKASI** (42/42 URL
> attempted — 40 halaman form nyata + 1 konfirmasi 404 (`addGl`, tidak ada) + 6 listing
> dikonfirmasi TIDAK punya tombol Tambah sama sekali). Field yang dicatat di bawah
> ringkasan label saja (bukan full HTML) — untuk struktur lengkap (urutan visual,
> `name` attribute asli, JS validasi, opsi dropdown), buka file mentah di `html/`.
> **Form EDIT masih 1/82 saja** — lihat bagian paling bawah, ini gap yang belum ditutup.

## Cara URL "Tambah" ditemukan
Tombol "+" di tiap listing kadang `<a href="...">` langsung, kadang `onclick="otorisasiAdd()"`
yang isinya cek otorisasi mundur-tanggal dulu baru redirect. Diekstrak dari HTML mentah
tersimpan (`html/`) via grep/regex, bukan tebakan.

**Temuan bug SISCOM**: 10 halaman transaksi (`piListing`, `siListing`, `apPaymentListing`,
`arReceiptListing`, `poCloseListing`, `pqCloseListing`, `soCloseListing`, `sqCloseListing`,
`prListing`, `roListing`) semua pakai fungsi `otorisasiAdd()` yang REDIRECT ke `addPo` —
**kemungkinan besar bug copy-paste di kode SISCOM sendiri** (fungsi disalin dari halaman PO
tanpa update URL tujuan). URL asli untuk 5 dari halaman ini (yang belum ada di daftar
sebelumnya) berhasil ditebak+diverifikasi via HTTP 200 + judul halaman cocok:
`addSi` (Faktur Penjualan), `addApPayment` (Hutang Dagang|Pembayaran), `addArReceipt`
(Piutang Dagang|Penerimaan), `addPr` (Retur Pembelian), `addRo` (Nota Penerimaan Barang).

**Temuan false-positive**: `addPosForm` muncul sebagai link `/add...` di HAMPIR SEMUA
halaman (termasuk `userListing`, `branchListing`, `apBeginListing`, `arBeginListing`,
`userMenuListing`, `logListing`) — ini shortcut sidebar global ke form POS, BUKAN tombol
"Tambah Data" spesifik per halaman. Setelah dicek manual, ke-6 listing di atas memang
TIDAK punya tombol Tambah sendiri (murni administrative/report listing).

**`addGl` tidak ada** — fetch mengembalikan HTTP 200 tapi redirect ke `pageNotFound`
("SISERP : Error 404"). General Ledger kemungkinan murni view/report (turunan otomatis dari
posting jurnal), tidak punya form create manual — konsisten dengan Jurnal Posting sebagai
satu-satunya cara data masuk GL.

## Field per halaman (SEMUA yang berhasil diverifikasi)

### Master Data
**Master Barang** (`addGoods`) — **Jenis**, **Tambah Satuan?** + **Multi Satuan** (konversi
satuan — 1 box = 12 pcs — **GAP: skema kita cuma 1 Satuan per produk**), scan barcode
langsung di form.

**Master Gudang** (`addWh`) — **Otorisasi \*** (wajib, akses per-gudang), Lokasi, Lokasi 2, Group.

**Merek/Brand** (`addBrand`) — Kode, Nama, Foto — sederhana.

**Kelompok Barang** (`addGoodsGroup`) — Kode, Nama, **Kode Pajak** (pajak per-kategori — gap
sudah tercatat di `02-gap-analysis.md`).

**Kelompok Std Harga Jual** (`addSalesPriceGroup`) — Kode, Nama — basis multi-tier pricing.

**Satuan** (`addUnit`) — Kode, Nama — master unit dasar (dipakai di Multi Satuan `addGoods`).

**Ukuran/Size** (`addSize`) — Kode, Nama — untuk varian produk (mis. ukuran case HP).

**Bahan Baku** (`addRawMaterial`) / **Bahan Jadi** (`addFinMaterial`) — field mirip Master
Barang sederhana, dipakai modul Perakitan (Bahan Baku → Barang Jadi, masih ❌ di desain kita).

**Kelompok Supplier** (`addSuppGroup`) / **Kelompok Pelanggan** (`addCustGroup`) — Kode, Nama
— grouping untuk laporan/pricing per-kelompok.

**Supplier** (`addSupp`) — Kode\*, Status, Alamat, Telp + blok upload foto (`fotoOld`,
`filefoto`) — field NPWP/Limit Hutang/Uang Muka ada di scroll lanjutan (form panjang,
field generik `colx/tablex/valx/formx` = builder dinamis kolom custom SISCOM).

**Pelanggan/Customer** (`addCust`) — sama pola dengan Supplier: Kode\*, Status, Nama\*,
**Kelompok Harga** (link ke `addSalesPriceGroup` — konfirmasi customer ditempel ke tier
harga tertentu), foto, field dinamis `colx/tablex/valx/formx`.

**Salesman** (`addSalesman`) — master data sales/tenaga penjual (dipakai di `addSi` field
"Salesman \*").

**Promo** (`addPromo`) — master data promosi (URL awalnya tidak ketemu grep otomatis,
resolved via grep manual di `promoListing`).

**Cost Centre** (`addCc`) — Kode\* saja yang utama — dimensi tambahan untuk COA (❌ di
desain kita, lihat gap analysis §6).

**Tipe Bayar** (`addPayType`) — Kode\*, Status, **POS** (flag boleh dipakai di kasir),
**Group T.Bayar** — field lanjutan (Acno/Achtg/Acptg/Aclsk/Acrsk, mapping ke 5 akun COA
berbeda per tipe bayar) ada di scroll lanjutan, sudah tercatat di gap analysis §5.

**Bank** (`addBank`) — form SANGAT pendek: cuma **Kode\*** + field mapping akun
(Acno/Acdb/Ackr/Accr/Acbatal) di bagian lanjutan.

### Persediaan (lanjutan)
**Stok Opname** (`addStockOpname`) — Kelompok Barang, **Diopname oleh**.

**Transfer Gudang** (`addTransferWh`) — Gudang Dari/Ke, Pilih TS (tipe transfer).

**Transfer Sementara** (`addTransferTemp`) — mirip Transfer Gudang tapi untuk transfer yang
BISA DIBALIK (2 jenis transfer, gap tercatat §1).

**Penyesuaian Persediaan** (`addAdjustStock`) — Nomor Faktur\*, Cabang\*, **Penyesuaian \***
(jenis penyesuaian), Pilih Barang, **listimei** (bisa adjust per-unit IMEI/serial spesifik,
bukan cuma per-qty), rentang tanggal `from/to`.

### Pembelian
**Surat Permintaan Barang/PR-internal** (`addPq`) — No. Faktur\*, Cabang\*, Tgl. Faktur\*,
**cekppn** (flag PPN), Pilih Barang, totqty.

**Retur Pembelian** (`addPr`) — Nomor Faktur\*, Cabang\*, Tanggal\*, Supplier\*, **cekppn**,
Hari/Jatuh Tempo, **Berdasarkan \*** (retur harus merujuk transaksi asal — konsisten dgn
pola `addSr` di bawah).

**Nota Penerimaan Barang/Receive** (`addRo`) — Nomor Faktur\*, Cabang\*, Supplier\*,
**cekppn**, Hari/Jatuh Tempo, ada widget kalender bulan (Jan-Feb-Mar...) untuk cicilan/jadwal
— konfirmasi Receive = dokumen independen dari Invoice (3-way matching, §3 gap analysis).

**Saldo Awal Persediaan Barang** (`addGoodsBegin`) — Nomor Faktur\*, Cabang\*, Supplier\*,
Pilih Barang, totqty/totprice — opening stock per SUPPLIER (bukan cuma per akun COA, gap §6).

### Penjualan
**Faktur Penjualan/SI** (`addSi`) — Nomor Faktur\*, Cabang\*, Pelanggan\*, **Salesman \***,
Referensi, Hari/Jatuh Tempo, `nopj` (nomor PO customer referensi).

**Order Penjualan/SO** (`addSo`) — **Pilih SQ** (link ke Quote asal), Discount, **PPN (%)**,
Ongkos, Netto.

**Penawaran/Quote** (`addSq`) — dokumen awal alur B2B (Quote → SO → DO → Invoice, simetris
Purchasing — gap §4).

**Retur Penjualan** (`addSr`) — **Berdasarkan \*** + **Pilih Faktur SI** (retur SELALU
merujuk invoice asal spesifik, bukan retur bebas), field `listimei` (retur per-unit
serial/IMEI juga ada di sisi penjualan, simetris `addAdjustStock`).

**Delivery Order/DO** (`addDo`) — field `listimei` + `tempflagimei` — **konfirmasi
penting**: proses SCAN IMEI/Serial terjadi di tahap DO (packing/pengiriman), bukan di
Invoice — cocok dengan desain kita soal Packing Station scan-IMEI-saat-packing.

### Keuangan
**Uang Muka Pembelian** (`addApDownPayment`) — Nomor Faktur\*, Supplier\*, Pilih Barang.

**Pembayaran Hutang** (`addApPayment`) — Voucher\*, Cabang\*, Supplier\*, No. Faktur (pilih
faktur yang dibayar), **gironormalTemp/tglgiroTemp/nominalgiroTemp** (pembayaran via Giro
langsung terintegrasi di form ini, bukan modul terpisah).

**Uang Muka Penjualan** (`addArDownPayment`) — Nomor Faktur\*, Pelanggan\*, Pilih Barang.

**Faktur Piutang/AR Invoice** (`addArInvoice`) — Cabang\*, Pilih Customer, Pilih Faktur
Penjualan (link eksplisit ke SI asal).

**Penerimaan Piutang** (`addArReceipt`) — Nomor Faktur\*, Cabang\*, Pilih Customer, No.
Faktur, field Giro juga terintegrasi (sama pola dgn ApPayment).

**Penerimaan Kas/Bank** (`addCashBankReceipt`) — Voucher\*, Cabang\*, **Kode Akun \***,
Terima Dari, Detail multi-baris (Pilih No Akun per baris — bisa split ke beberapa akun
sekaligus dalam 1 voucher).

**Pengeluaran Kas/Bank** (`addCashBankPayment`) — sama pola dgn Receipt: Voucher\*, Cabang\*,
Kode Akun\*, **Dibayar Kepada**, Detail multi-akun.

**Transaksi Bank** (`addBankTransaction`) — No. Voucher\*, Cabang\*, **Bank \***, **Pilihan
Transaksi** (jenis transaksi bank), **Pilih Giro \*** — transaksi bank terhubung langsung ke
modul Cheque/Giro.

**Cheque/Giro** (`addChequeTransaction`) — No. Giro\*, Cabang\*, Nominal, Pilih Customer,
Pilih Giro — konfirmasi Cheque/Giro py lifecycle module sendiri (gap §5, "bisa ditunda"
kalau tenant tidak pakai giro — **PERLU DIKONFIRMASI ke user: Leon Sellular pakai giro atau
tidak** sebelum diputuskan prioritas).

### Akunting
**Chart of Accounts** (`addCoa`) — 6 field akun terpisah (Level 1-6), **Cost Centre \***
(wajib), **Anggaran / Thn** (budget tahunan per akun).

**Aktiva Tetap/Fixed Assets** (`addFa`) — **Periode Susut**, **Penyusutan (Berapa Bulan)**,
**Nilai Buku**, **Posting [DR]/[CR]** (akun otomatis untuk jurnal depresiasi).

**Recurring** (`addRe`) — Kode\*, Cabang\*, **ACNO**, **Periode Susut \***, **Penyusutan**,
**Nilai Buku \***, **Posting [DR] \*** — TERNYATA field-nya sangat mirip dengan Fixed Assets
(kemungkinan Recurring Journal SISCOM diimplementasikan sebagai varian dari mesin
depresiasi/posting terjadwal yang sama, bukan modul jurnal berulang generik terpisah).

**Jurnal Manual** (`addJournal`) — Voucher\*, Tanggal, Referensi, Cabang, **totalDebet /
totalKredit / selisih** (validasi balance real-time saat input, `selisih` harus 0 sebelum
submit) — grid multi-baris debit/kredit per akun.

**Tutup Buku/Close Book** (`addCloseBook`) — **Pilih Periode [Ke]** — form pendek, cuma
pilih periode tujuan tutup buku tahunan (terpisah dari Tutup Periode bulanan, konfirmasi
gap §7).

**General Ledger** (`addGl`) — **TIDAK ADA** (404). GL murni hasil otomatis dari posting
jurnal, tidak ada create manual.

## Halaman dikonfirmasi TIDAK punya form Tambah
`userListing`, `branchListing`, `apBeginListing`, `arBeginListing`, `userMenuListing`,
`logListing` — dicek via grep `href="...add*"` di HTML mentah masing-masing; satu-satunya
match adalah `addPosForm` (shortcut sidebar global yang muncul di SEMUA halaman, bukan
tombol spesifik). Kemungkinan besar administrasi user/cabang/log/saldo-awal dilakukan via
form lain (Setting, atau edit-in-place di listing itu sendiri) — belum dikonfirmasi lebih
jauh karena di luar scope "Tambah Data" (dan menyentuh area User Management yang lebih
sensitif untuk diklik-uji).

## Halaman "murni FORM AKSI" (bukan listing+tambah — TIDAK relevan pola ini)
`changePeriod`, `closePeriod`, `dataMaintenanceForm`, `dataValidationForm`, `unlockKey`,
`initBalance`, `journalPostingForm`, `printBarcodeForm`, `pointSetting`, `defaultSetting`,
`imeiCrossCheckForm`, `minStockForm`, `journalCheckForm`, `hppStockForm`,
`errorCrossCheckForm`, `deleteData`, `updateStockFormulaForm`, `acSetting`,
`acAnalysisSetting`, `snStatusReport`, `eFakturForm` — form-nya sendiri sudah jadi
satu-satunya aksi (tidak ada listing terpisah + tombol Tambah). Tidak diproses dalam
putaran ini karena bukan bagian dari pola "Tambah Data"; kalau dibutuhkan detail fieldnya,
perlu putaran audit terpisah.

## Edit form
**Masih cuma 1 halaman** yang pernah dibuka detail (`editGoodsForm/{group}-{kode}` — Master
Barang, riwayat di `docs/00-status.md` #18). Form edit untuk 81 halaman lain **belum pernah
dibuka sama sekali** — ini gap besar yang tersisa, belum diminta eksplisit oleh user di
putaran audit ini (fokusnya baru "Tambah"), tapi perlu di-flag untuk sesi berikutnya kalau
mau klaim cakupan benar-benar 100%.

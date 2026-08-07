# Form "Tambah" (Create) — Field Inventory

> **Status: SEBAGIAN**, bukan lengkap 100% — lihat `docs/00-status.md` #21 untuk
> penjelasan jujur soal cakupan. Ini menambah `01-field-inventory.md` (yang cuma cover
> kolom LISTING) dengan field FORM CREATE ("Tambah Data") untuk halaman yang URL-nya
> berhasil dikonfirmasi.

## Cara URL "Tambah" ditemukan
Tombol "+" di tiap listing kadang `<a href="...">` langsung, kadang `onclick="otorisasiAdd()"`
yang isinya cek otorisasi mundur-tanggal dulu baru redirect. Diekstrak dari HTML mentah
tersimpan (`html/`) via grep, bukan tebakan.

**Temuan menarik**: beberapa halaman transaksi (`piListing`, `siListing`, `apPaymentListing`,
`arReceiptListing`, `poCloseListing`, `pqCloseListing`, `soCloseListing`, `sqCloseListing`,
`prListing`, `roListing`) semua py fungsi `otorisasiAdd()` yang REDIRECT ke `addPo` —
**kemungkinan besar bug copy-paste di kode SISCOM sendiri** (fungsi disalin dari halaman PO
tanpa update URL tujuan), BUKAN desain yang disengaja. Field form untuk halaman-halaman ini
TIDAK diambil (URL-nya tidak bisa dipercaya).

## Field per halaman (yang berhasil diverifikasi)

**Master Barang** (`addGoods`) — field TAMBAHAN dari yang sudah dicatat di
`01-field-inventory.md`: **Jenis**, **Tambah Satuan?** + **Multi Satuan** (konversi
satuan — 1 box = 12 pcs, dst — **GAP: skema kita cuma 1 Satuan per produk, SISCOM
mendukung multi-satuan**), fitur scan barcode langsung di form (bukan cuma di POS).

**Master Gudang** (`addWh`) — **Otorisasi \*** (wajib diisi, bukan opsional — konfirmasi
per-gudang access control itu REAL field, bukan asumsi saya sebelumnya), Lokasi, Lokasi 2,
Group.

**Stok Opname** (`addStockOpname`) — Kelompok Barang (bisa opname per-kategori, tidak
harus semua barang), **Diopname oleh** (siapa yang hitung fisik).

**Transfer Gudang** (`addTransferWh`) — Gudang Dari/Ke eksplisit, Pilih TS (tipe transfer).

**Order Penjualan/SO** (`addSo`) — **Pilih SQ** (link eksplisit ke Penawaran asal — SO
BENERAN diturunkan dari Quote via referensi, bukan cuma alur konseptual), Discount, **PPN
(%)**, Ongkos, Netto — breakdown pajak/ongkos/diskon lengkap saat create, bukan dihitung
belakangan.

**Chart of Accounts** (`addCoa`) — **6 field akun terpisah (Level 1-6, as1-as6, "Pilih
Akun" per level)** — konfirmasi definitif COA SISCOM hierarkis multi-segmen (bukan flat
code+parent_id seperti skema kita). Plus **Cost Centre \*** (wajib), **Anggaran / Thn**
(budget tahunan per akun — fitur budgeting terintegrasi ke COA, sama sekali tidak ada di
desain kita).

**Aktiva Tetap/Fixed Assets** (`addFa`) — **Periode Susut** (metode/periode
depresiasi), **Penyusutan (Berapa Bulan)** (durasi depresiasi), **Nilai Buku**, **Posting
[DR]/[CR]** (akun debit/kredit untuk jurnal depresiasi otomatis) — konfirmasi fixed asset
py depresiasi OTOMATIS terjadwal, bukan manual jurnal tiap bulan.

## Belum diverifikasi (URL sudah ketemu tapi field belum diambil)

~29 URL "Tambah" lain sudah berhasil diidentifikasi tapi belum di-fetch detail field-nya:
`addBrand`, `addGoodsGroup`, `addSalesPriceGroup`, `addUnit`, `addSize`, `addAdjustStock`,
`addRawMaterial`, `addFinMaterial`, `addTransferTemp`, `addSuppGroup`, `addPq`,
`addCustGroup`, `addCust`, `addPromo`, `addSq`, `addSr`, `addDo`, `addBank`,
`addBankTransaction`, `addChequeTransaction`, `addApDownPayment`, `addApReceipt`,
`addArDownPayment`, `addArInvoice`, `addCashBankReceipt`, `addCashBankPayment`,
`addJournal`, `addGl`, `addRe`, `addGoodsBegin`, `addCloseBook`, `addSalesman`.

## Belum sama sekali (URL tidak berhasil diidentifikasi via grep otomatis)

Halaman yang murni FORM AKSI (bukan listing+tambah, kemungkinan tidak punya konsep
"Tambah" terpisah — form-nya sendiri sudah jadi satu-satunya aksi): `changePeriod`,
`closePeriod`, `dataMaintenanceForm`, `dataValidationForm`, `unlockKey`, `initBalance`,
`journalPostingForm`, `printBarcodeForm`, `pointSetting`, `defaultSetting`,
`imeiCrossCheckForm`, `minStockForm`, `journalCheckForm`, `hppStockForm`,
`errorCrossCheckForm`, `deleteData`, `updateStockFormulaForm`, `acSetting`,
`acAnalysisSetting`, `snStatusReport`, `eFakturForm` — juga `userListing`,
`userMenuListing`, `branchListing`, `logListing`, `apBeginListing`, `arBeginListing`
(kemungkinan besar PUNYA tombol Tambah tapi grep otomatis tidak menangkap pola URL-nya,
belum diverifikasi manual).

## Edit form
**Cuma 1 halaman** yang pernah dibuka detail (`editGoodsForm/{group}-{kode}` — Master
Barang, lihat riwayatnya di `docs/00-status.md` #18 sebelum file lama dihapus). Form edit
untuk 81 halaman lain **belum pernah dibuka sama sekali**, baik manual maupun via fetch.

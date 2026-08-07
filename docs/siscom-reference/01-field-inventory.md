# Field Inventory — Lengkap per Halaman

Field generik `Doe/Toe/Loe/Deo/Actions` (audit-trail bawaan) dihilangkan dari semua daftar
di bawah, lihat `00-overview.md`. `n` = jumlah baris data di periode Agt 2026 (0 = kosong
periode ini, bukan berarti fitur tidak dipakai).

## Persediaan (Inventory)

| Halaman | Field kunci |
|---|---|
| Master Satuan (`unitListing`) | Kode, Nama, Aktif — sederhana. 2 data: PCS, UNIT |
| Master Ukuran (`sizeListing`) | sama pola dengan Satuan |
| Kelompok Barang (`goodsGroupListing`) | Kode, Inisial, Nama, **POS** (flag boleh dijual di POS), **HD** (Header/Detail), **Kode Pajak**, Aktif — kategori punya kode pajak sendiri |
| Master Brand (`brandListing`) | Kode, Nama Brand, Aktif — 29 brand terdaftar |
| **Master Barang** (`goodsListing`) | Kode, Group, Inisial, Nama, Barcode, **Tracking** (1=Serial/IMEI, 2=lainnya — SATU flag, bukan 2 tipe), Satuan, Stdbeli, Std.Jual, Minjual, Minstok, Maxstok, Aktif, Stok, **Jenis**. 1,843 produk. Form edit py juga: Merek, POS(flag), Perolehan Poin(flag), Fast/Slow/Dead Moving(%), Link Stock+Pilih Barang(bundling), tabel riwayat harga per Kelompok Std Jual |
| Kelompok Std. Harga Jual (`salesPriceGroupListing`) | Kode, No.Faktur, Nama, Cabang, Ingroup, Id1-3 |
| **Master Gudang** (`whListing`) | Kode, Nama, **Alamat1, Alamat2** (2 alamat), Telp, Cabang, **Otorisasi** (akses per-user?), Aktif. 5 gudang: PT LEON, NON PKP, SERVICE, PT SUPER LEON, RUSAK/BAD STOK — **status barang (rusak/service) = GUDANG FISIK, bukan flag** |
| Cetak Barcode (`printBarcodeForm`) | Template label: Kolom, Lebar/Tinggi Kertas(inch), Lebar/Tinggi label(inch), Baris1-3(px), Padding-top(px), Default Printer |
| Stok Opname (`stockOpnameListing`) | No.Faktur, Cabang, Gudang, Tgl.Faktur, Jumlah Barang, **Total Stok vs Total Fisik**, Pembuat, Ingroup, Flag, Sign |
| Transfer Sementara/Gudang (`transferTempListing`/`transferWhListing`) | No.Faktur, No.Referensi, Tgl.Faktur, **Gudang → Pindah** (asal→tujuan terpisah), Cabang, Validasi, **Accounting** (transfer py dampak jurnal!) |
| Penyesuaian Persediaan (`adjustStockListing`) | +Qty, **Harga Netto** (nilai uang), Tipe, Validasi, Accounting |
| Perakitan § Pemakaian Bahan Baku (`rawMaterialListing`) | No.Faktur, Qty, Harga Total, Uang, Kurs, Ket1-4, Validasi, Accounting |
| Perakitan § Penyelesaian Barang Jadi (`finMaterialListing`) | sama + Ref.Tr |
| Laporan Status S/N (`snStatusReport`) | Lookup by 1 field: **"S/N"** (bukan "IMEI" — istilah umum) |

## Pembelian (Purchasing)

| Halaman | Field kunci |
|---|---|
| Kelompok Supplier (`suppGroupListing`) | Kode, Inisial, Nama, HD, Aktif |
| **Supplier** (`suppListing`) | Kode, Nama, Alamat1-2, Telp, Fax, Hp, Email, Kontak, **Npwp**, Lokasi, Term, **Limit Hutang**, Hutang, **Uang Muka**, Batas, Aktif. 92 supplier — termasuk "CASH USER" (Hutang 896jt!), "BLIBLI" (marketplace SEBAGAI supplier), "AKULAKU" (fintech paylater sbg supplier) |
| Surat Permintaan Barang/PR (`pqListing`) | Qty, **Outs**(standing), Term, Uang, Kurs, Discd/Disch/Diskon, Biaya, Taxn, Validasi |
| Tutup SPB (`pqCloseListing`) | + Harga Netto, Harga Total, Ref.Tr |
| **Order Pembelian/PO** (`poListing`) | + Harga Netto, Harga Total, Supplier, Kel.Supplier |
| **Faktur Pembelian/PI** (`piListing`) | No.Faktur (format `PI-2026/08-0113`), Supplier, Total Qty, Harga Netto, **Status**, Ref.Tr, Validasi, Accounting. 113 record periode ini, total Rp 7.87M (cocok Dashboard) |
| Retur Pembelian (`prListing`) | Status, Ref.Tr, Taxn |
| Nota Penerimaan (`roListing`) | + Taxp, Lain — field pajak lebih detail dari PI |

## Penjualan (Sales)

| Halaman | Field kunci |
|---|---|
| Kelompok Pelanggan (`custGroupListing`) | Kode, Inisial, Nama, HD, Aktif |
| Salesman (`salesmanListing`) | Kode, Nama, Alamat1-2, Cabang, **Tipe**, Telp, Hp. 45 salesman |
| **Pelanggan** (`custListing`) | Kode, Nama, Alamat1-2, Telp, FAX, Hp, Email, **Npwp**, Kontak, Kel.Pelanggan, Salesman, Term, **Limit, Piutang, Uang Muka, Sisa Limit**, Aktif. 61 customer — simetris persis dengan Supplier (credit limit management 2 arah) |
| Tabel Point (`pointSetting`) | form config (belum ada data contoh) |
| Promo (`promoListing`) | No.Faktur, Nama, Cabang, **Tipe**, Flag |
| Penawaran/SQ (`sqListing`) | mirror PR/PQ tapi utk customer |
| **Order Penjualan/SO** (`soListing`) | 36 kolom total (termasuk banyak field internal Id1-3/Doe/Loe/Toe/Discd/Disch/Discn/Ket1-4) |
| Tutup SO (`soCloseListing`) | + **Um**(uang muka), **Pajak**, **Bayar**, Ketb, Ketl, Kket1-4, Qtx, Qtz, Ketprt — SO yang ditutup py breakdown pembayaran lengkap |
| Nota Pengiriman/DO (`doListing`) | standar + Accounting |
| **Faktur Penjualan/SI** (`siListing`) | Total Qty, Harga Netto, Status, **Wilayah** (bukan Kel.Pelanggan seperti PI — beda dimensi), Salesman |
| Retur Penjualan (`srListing`) | (belum sempat diverifikasi detail, pola sama SR/PR) |
| **Point Of Sale** (`addPosForm`) | Field form: **No. Meja**, cetakimei, jenisfaktur/jenisukur/jeniscetak, **btn-faktur-pajak** (tombol e-Faktur LANGSUNG di POS), **saldokas** (cash drawer), **ketvoid**(alasan void), fitur **Cek Harga** (scan barcode cek harga tanpa checkout: inputBarcodeCekHarga/selectNamaBarangCekHarga/btnCekHarga) |
| E-Faktur (`eFakturForm`) | Nomor, Tanggal, Nama, **No. Seri** (nomor seri faktur pajak DJP, beda dari serial produk), Netto |

## Keuangan (Finance)

| Halaman | Field kunci |
|---|---|
| Tipe Bayar (`payTypeListing`) | Kode, Nama, **Giro, Kartu, Dp**(flag), Group Tipe Bayar, **Otor**, Charge, **Acno/Achtg/Acptg/Aclsk/Acrsk** (6 field akun COA berbeda per tipe bayar!), Cabang, Pos(flag). **Tiap metode bayar mapping ke akun COA spesifik** |
| Bank (`bankListing`) | Kode, Nama, A/c, A/n, Acno, Acdb, Ackr, Accr, Acbatal — juga py mapping akun |
| Transaksi Bank (`bankTransactionListing`) | Bank, Nilai, **Saldo** (running balance), Acno, Validasi, Accounting |
| Cheque/Giro (`chequeTransactionListing`) | Nogiro, Jtgiro(jatuh tempo giro), Nilai, Vendor, Saldo, **Tolak, Batal** (giro bisa ditolak/dibatalkan — status lifecycle sendiri), Girono, Sign |
| Hutang Dagang § Tanda Terima (`apReceiptListing`) | Saldo, Supplier |
| Hutang Dagang § Uang Muka (`apDownPaymentListing`) | — |
| Hutang Dagang § Pembayaran (`apPaymentListing`) | **Bayar, Potongan, Biaya, Skurs**. 10 record periode ini |
| Piutang Dagang § Nota Tagihan (`arInvoiceListing`) | Saldo, Potongan, Bayar, Discn, Biaya |
| Piutang Dagang § Uang Muka (`arDownPaymentListing`) | Saldo |
| Piutang Dagang § Penerimaan (`arReceiptListing`) | Bayar, Potongan, Biaya. 10 record |

## Akunting (Accounting)

| Halaman | Field kunci |
|---|---|
| **Kode Perkiraan/COA** (`coaListing`) | Kode, Nama, **H/D**(Header/Detail — hierarkis), **Level**, **AC1-AC6** (6 SEGMEN kode akun — bukan 1 kode flat!), Tipe, **D/C**(saldo normal), **CC**(link Cost Centre), Jenis Transaksi |
| Cost Centre (`ccListing`) | Kode, Nama, Init. 5 cost centre aktif dipakai |
| Setting Akun Transaksi/Analisis (`acSetting`/`acAnalysisSetting`) | form config |
| Penerimaan/Pembayaran Kas Bank (`cashBankReceiptListing`/`PaymentListing`) | Jumlah, Bagian(dept?), Pelanggan/Supplier |
| Jurnal Umum (`journalListing`) | Debet, Kredit, **Ndrcr**, **Posted**(flag) |
| Jurnal Trading/GL (`glListing`) | + Accounting |
| **Aktiva Tetap/Fixed Assets** (`faListing`) | Kode, Nama, **Nilai Perolehan, Depresiasi**, Acdr/Accr/Acno, Periode, Validasi, Posted. 10 aset aktif — **modul lengkap tidak ada di desain kita sama sekali** |
| Recurring (`reListing`) | sama pola dengan Aktiva Tetap + Nomor Si |
| Jurnal Posting (`journalPostingForm`) | form action terpisah — "posting" adalah aksi eksplisit sendiri, bukan otomatis |

## Utiliti

| Halaman | Field kunci |
|---|---|
| **Setting Cabang** (`branchListing`) | Kode, Nama, Alamat1-2, Telp, FAX, **GROUP CABANG** (level di atas Cabang!), **NPWP** (per-Cabang, bukan cuma per-Tenant), KET1-4, Aktif |
| Setting Password → **User** (`userListing`) | Usid, Username, Email, Deskripsi, **Level**. 10 user (cocok Dashboard) |
| Setting Menu User (`userMenuListing`) | ID, Nama, Email, Level, **Jumlah Menu** (hak akses menu per-user, granular) |
| Ganti/Tutup Periode, **Tutup Buku**, Buka Kunci Data, Validasi Data | semua form action (bukan listing) — **"Tutup Buku" (year-end close) TERPISAH dari "Tutup Periode" (month close)**, 2 level closing berbeda |
| Maintenance Data | form action (terlihat di Aktivitas Dashboard: "Maintenance Data Periode 08/2026 (Mulai/Selesai)" — proses berdurasi, bukan instan) |

## Saldo Awal

| Halaman | Field kunci |
|---|---|
| Persediaan Barang (`goodsBeginListing`) | Saldo awal STOK per produk (bukan cuma akun akuntansi!) |
| Hutang Dagang / Piutang Dagang Awal | saldo awal AP/AR per supplier/customer |
| Neraca Awal (`initBalance`) | saldo awal per akun COA (Neraca = Balance Sheet) |

## Help / Tools (diagnostic, prioritas rendah)

| Halaman | Field kunci |
|---|---|
| **Kroscek Imei** (`imeiCrossCheckForm`) | tool cross-check validitas IMEI |
| Minus Stock (`minStockForm`) | Tanggal, No.Faktur, No.Order, **+/-**, Fisik — pelacakan penyebab stok minus |
| Jurnal Check, Kroscek Error, Update Stok Formula | tools data-repair, tidak perlu direplikasi di awal |
| **Laporan Hapus Data** (`deleteData`) | audit trail KHUSUS untuk data yang dihapus |
| **Laporan Log** (`logListing`) | Log Date, Log User, User Name, **Log IP**, Log Description — 10 record. Ini = `audit_logs` kita, TAPI py **Log IP** yang tidak ada di skema kita |

# Form "Edit" (Ubah Data) — Field Inventory

> **Status: 21 dari 82 halaman** berhasil diverifikasi dengan URL edit REAL (bukan tebakan)
> + field-nya diambil (naik dari 15 setelah user mengonfirmasi submit form filter/cari
> boleh dilakukan — lihat `docs/00-status.md` #23-24). Sisanya sebagian besar **TERKONFIRMASI
> KOSONG** (tenant "leon" belum pernah pakai modul itu — bukan gagal diaudit, tapi memang
> tidak ada datanya) dan sebagian kecil pakai arsitektur AJAX terpisah yang belum
> ditelusuri — lihat rincian di bawah.

## Cara URL Edit ditemukan (metode BEDA dari form Tambah)

Beda dengan URL "Tambah" yang cukup 1 per halaman, URL "Edit" butuh **ID record asli**
(`editGoodsForm/{group}-{kode}`, `editSrForm/{nomor}`, dst) — tidak bisa ditebak/dikonstruksi
tanpa tahu data riil yang ada di database tenant "leon".

Ditemukan 2 pola render listing di SISCOM:
1. **Server-rendered** (mis. `brandListing`, `whListing`, `custListing`, `srListing`) — HTML
   awal yang dikirim server SUDAH berisi baris data asli lengkap dengan `href` edit yang
   valid (mis. `href="https://myapp.siscom.id/editBrandForm/020"`). ID asli bisa langsung
   diambil dari file HTML yang sudah tersimpan di `html/` tanpa fetch tambahan.
2. **Client-rendered via AJAX** (mis. `goodsListing`, `soListing`, `siListing`, dan
   HAMPIR SEMUA listing transaksi) — HTML awal cuma kerangka tabel kosong. Baris data
   (dan karena itu ID record asli) baru muncul setelah JS memanggil AJAX. Untuk sebagian
   (mis. `goodsListing`) AJAX terpanggil otomatis saat halaman dimuat. **Untuk mayoritas
   modul TRANSAKSI, AJAX BARU terpanggil setelah user submit form filter/cari** (dikonfirmasi
   via network inspection di `soListing`: 0 request data terkirim sampai form "Cari"
   di-submit manual) — SISCOM sengaja tidak auto-load semua transaksi historis demi performa.

## Metode lanjutan (setelah user konfirmasi submit form filter/cari diizinkan)

User eksplisit mengizinkan submit form filter/cari (search-only, bukan create/update/
delete) untuk lanjut audit modul transaksi. Ditemukan cara EFISIEN untuk ini: form
`#searchList` di tiap listing method-nya POST ke URL listing itu sendiri (server
re-render HTML lengkap dgn baris data) — jadi **tidak perlu navigasi tab sama sekali**,
cukup `fetch(url, {method:'POST', body: <form fields default>, credentials:'include'})`
dari konteks manapun, lalu parse HTML hasilnya dgn `DOMParser` utk cari baris pertama +
ekstrak ID record asli dari atribut `onclick`/`ondblclick` (pola: `openRowEdit('ID',...)`
atau `otorisasiEdit(tgl,'ID',...)`). Kalau ID dari onclick kosong, fallback ke isi kolom
pertama tabel (biasanya kolom "Kode"/"No. Faktur" itu sendiri).

**Pengecualian**: `goodsListing` dan `coaListing` TIDAK memakai pola ini (data mereka
diisi via AJAX endpoint terpisah, bukan POST balik ke listing URL sendiri) — untuk
`goodsListing` diakali pakai endpoint pencarian barang `Utility/searchBarangNama`
(dipakai widget "scan barcode" di banyak halaman) yang mengembalikan JSON KODE/GROUP asli
langsung. `coaListing` **belum ditemukan cara amannya** — endpoint AJAX aslinya belum
ditelusuri, jadi form Edit COA masih belum terverifikasi.

## Field per halaman (21 yang berhasil diverifikasi, via URL edit REAL)

### Baru dari putaran kedua (submit form filter/cari)

**Faktur Penjualan/SI** (`editSiForm/SI2026080166`) — field HAMPIR SAMA dgn `addSi`, plus
field baru yang cuma muncul di Edit: **noseri** (nomor seri/urut internal), **Pilih Data
\*** (kemungkinan pilihan dokumen sumber saat edit — mirip pola "Berdasarkan" di Retur),
widget kalender bulan (Jan-Feb-Mar...) + tahun (jadwal cicilan/termin pembayaran).

**Faktur Pembelian/PI** (`editPiForm/PI2026080113`) — field mirip `addPi` (belum pernah
diaudit form Tambah-nya secara terpisah karena PI termasuk 10 halaman kena bug
`otorisasiAdd()`→`addPo`, dan URL Tambah PI sendiri belum pernah dikonfirmasi — **temuan
baru**: berarti field PI baru benar-benar terdokumentasi lewat form Edit ini): Nomor
Faktur, Cabang, Referensi, Hari/Tanggal Jatuh Tempo, **Pilih Data \***, Supplier\*,
kalender bulan+tahun, **PI** (nomor PI eksplisit sbg field terpisah), **cekppn**, Pilih
Barang.

**Kelompok Barang** (`editGoodsGroupForm/001`) — kode, Aktif, **inisial** + **inisial1**
(2 kode inisial berbeda — kemungkinan singkatan utk 2 konteks tampilan berbeda,
struk vs laporan), **Detail Header** (flag baris ini header/parent kategori atau bukan —
konfirmasi ulang Kelompok Barang SISCOM hierarkis, bukan flat), Nama\*.

**Kelompok Pelanggan** (`editCustGroupForm/001`) — Kode\*, Status, **Inisial \***, **Tipe
\*** — field lebih lengkap dari dugaan sebelumnya (form Tambah `addCustGroup` cuma
tercatat Kode+Nama, ternyata ada Inisial+Tipe juga).

**Kelompok Supplier** (`editSuppGroupForm/001`) — sama pola dgn Kelompok Pelanggan:
Kode\*, Status, Inisial\*, Tipe\*.

**Master Barang** (`editGoodsForm/001-00563`) — konfirmasi ulang **Kelompok** (assign ke
Kelompok Barang) sbg field terpisah dari Kode/Status — melengkapi field yang sudah
tercatat sebelumnya dari `addGoods`.

### Dari putaran pertama (URL edit statis/server-rendered)

**Master Gudang** (`editWhForm/00001`) — field sama persis dgn form Tambah (Kode\*,
**Otorisasi \***, Status, Lokasi, Lokasi 2, Group) — konfirmasi edit = reuse template Tambah,
cuma pre-filled.

**Master Brand** (`editBrandForm/020`) — Kode (read-only saat edit, field `kode`/`cntKode`
terpisah dari `Kode` display), Aktif, Nama\* — field TAMBAHAN vs Tambah: flag validasi
`aktifH` (history status aktif).

**Master Satuan** (`editUnitForm/PCS`) — kode, Aktif, Nama, **Kode Pajak** (field pajak per
satuan — belum pernah tercatat sebelumnya, bahkan di form Tambah `addUnit` cuma Kode+Nama;
kemungkinan Kode Pajak baru muncul di edit atau ke-skip waktu audit Tambah).

**Cost Centre** (`editCcForm/01`) — Kode, sama sederhana dgn Tambah.

**Setting Cabang / Branch** (`editBranchForm/01`) — Kode\*, Alamat, Telp, **FAX**, **NPWP**,
Tanggal — konfirmasi **NPWP memang di level Cabang** (bukan cuma Tenant), sesuai gap
analysis §7. Field dinamis `colx/tablex/valx/formx` (builder kolom custom) + upload foto.

**Supplier** (`editSuppForm/00028`) — Kode\*, Status, Alamat, Telp, **Fax**, **HP** — field
lanjutan Limit Hutang/NPWP/Uang Muka kemungkinan ada di scroll lanjutan form (sama seperti
`addSupp`, tidak semua field ter-capture di ekstraksi label ringkas).

**Pelanggan/Customer** (`editCustForm/00004`) — Kode\*, Status, **Kelompok \*** (wajib saat
edit, field ini di Tambah kelihatan opsional), **Sales \*** (assign salesman ke customer),
Nama\*, Kelompok Harga.

**Salesman** (`editSalesmanForm/001`) — Kode\*, Status, **Non Sales** (flag — salesman bisa
ditandai "bukan sales aktif" tanpa dihapus), Nama\*, **Cabang** (assign salesman ke cabang
spesifik), Alamat.

**Tipe Bayar** (`editPayTypeForm/01`) — Kode\*, Status\*, POS, **Kartu**, **Uang Muka** (2
field baru yang tidak kelihatan di ekstraksi `addPayType` — flag apakah tipe bayar ini kartu
kredit/debit, dan apakah termasuk kategori uang muka).

**Bank** (`editBankForm/01`) — Kode — sesederhana form Tambahnya.

**Aktiva Tetap/Fixed Assets** (`editFaForm/0010`) — field identik dgn `addFa` (Periode
Susut, Penyusutan per bulan, Nilai Buku, Posting DR/CR) — konfirmasi ulang skema depresiasi
otomatis, kali ini dari record NYATA yang sudah ada (bukan form kosong).

**Setting Password/User** (`editUserForm/L49`) — ID, Cabang, Gudang, **Default Printer
St[ruk]** — user py assignment eksplisit ke Cabang+Gudang tertentu (relevan utk desain
scoping `tenant_id`+cabang+gudang kita) + field dinamis `colx/tablex/valx/formx` + foto.

**Retur Penjualan** (`editSrForm/SR2026080009`) — judul halaman **"Edit Retur Penjualan"**
(bukan reuse title Tambah seperti halaman lain) — field: Nomor Faktur, Cabang, Nomor Cabang,
Tanggal, Pelanggan, **Salesman**, Referensi, Hari, Tanggal Jatuh Tempo, **Berdasarkan \***,
widget kalender bulan (Jan-Feb-Mar...) + tahun — HAMPIR SAMA dgn `addSr`, field tambahan
Salesman muncul di Edit tapi belum tercatat di ekstraksi `addSr` sebelumnya.

**Hutang Dagang | Pembayaran** (`editApPaymentForm/KR2026080117`) — identik field dgn
`addApPayment` (Voucher, Cabang, Tanggal, Supplier, No. Faktur, integrasi Giro
`gironormalTemp`/`tglgiroTemp`/`nominalgiroTemp`).

**Piutang Dagang | Penerimaan** (`editArReceiptForm/DB2026080022`) — identik dgn
`addArReceipt`, plus field Giro tambahan `ketgiro1Temp` yang tidak ter-capture sebelumnya.

## Error / gagal
**Setting Menu User** (`editUserMenuForm/L01`) — ID asli `L01` ditemukan dari HTML statis
`userMenuListing`, tapi saat di-fetch mengembalikan **"Database Error"** — kemungkinan
formatnya bukan `{level}` polos tapi butuh parameter tambahan (mis. kombinasi
level+menu-id), atau `L01` sebenarnya bukan level-code yang valid untuk endpoint ini.
Tidak dikejar lebih lanjut karena menyentuh area User/Access Management yang lebih sensitif
untuk uji coba berulang.

## Pola yang bisa disimpulkan (untuk desain kita, meski belum 100% halaman terverifikasi)
- **Form Edit hampir selalu = form Tambah yang sama, di-reuse, cuma di-pre-fill** (field set
  identik/nyaris identik di 20 dari 21 halaman yang dicek). Implikasi desain: kita tidak perlu bikin
  Blade/form terpisah untuk Create vs Edit per modul — cukup 1 komponen form yang menerima
  optional `$record` untuk mode edit, sama seperti pola form Laravel pada umumnya.
- Beberapa field EKSTRA baru muncul pas Edit yang tidak kelihatan di Tambah (Kode Pajak di
  Satuan, Kartu/Uang Muka di Tipe Bayar, Salesman di Retur Penjualan, ketgiro1Temp di AR
  Receipt) — kemungkinan field itu SEBENARNYA ada juga di form Tambah tapi terlewat waktu
  ekstraksi label (batasan metode ekstraksi: hanya ambil elemen visible di viewport
  awal/non-collapsed, form panjang dgn field di scroll/tab lanjutan bisa terlewat).

## Terkonfirmasi KOSONG (bukan gagal diaudit — memang tidak ada datanya di tenant "leon")

Dicek satu-satu via submit form filter/cari (kosong/default) — hasilnya 0 baris data utk
SEMUA halaman berikut. Ini **temuan bisnis nyata**, bukan kegagalan metode (dikonfirmasi
metode bekerja normal di halaman lain yang MEMANG ada datanya, mis. `siListing`,
`piListing`, `goodsGroupListing`): tenant "leon" sejauh ini baru pakai Faktur Penjualan
(SI) + Faktur Pembelian (PI) + master data dasar secara langsung — **belum pernah
menyentuh alur formal Quote→Order→Delivery (SQ/SO/DO/PQ/PO/RO/PR), retur pembelian,
uang muka AP/AR, cash/bank/giro/cheque, jurnal manual, stock opname/adjust/transfer, atau
fitur niche (Promo, Perakitan/Raw-Fin Material, Ukuran, Kelompok Std Harga Jual,
Recurring)**:

`soListing`, `poListing`, `doListing`, `sqListing`, `pqListing`, `roListing`,
`adjustStockListing`, `apDownPaymentListing`, `arDownPaymentListing`, `arInvoiceListing`,
`cashBankPaymentListing`, `cashBankReceiptListing`, `journalListing`,
`stockOpnameListing`, `transferWhListing`, `transferTempListing`, `reListing`,
`promoListing`, `rawMaterialListing`, `finMaterialListing`, `sizeListing`,
`salesPriceGroupListing`, `bankTransactionListing`, `chequeTransactionListing`,
`poCloseListing`, `soCloseListing` (dan kemungkinan besar `pqCloseListing`/
`sqCloseListing` juga kosong dgn alasan sama — tidak dicek satu-satu, karena "Tutup"
transaksi cuma mungkin ada kalau transaksi sumbernya sendiri ada, dan sumbernya
(PQ/SQ) sudah terkonfirmasi 0).

**Implikasi untuk audit**: field/struktur form Edit utk semua modul di atas TIDAK BISA
diverifikasi dari data live (tidak ada recordnya). Kalau dibutuhkan detail field Edit-nya,
satu-satunya cara adalah pakai struktur form Tambah yang sudah terdokumentasi
(`03-add-form-fields.md`) sebagai proxy — sudah terbukti di 20/21 halaman yang berhasil
dicek bahwa Edit = Tambah yang di-reuse, jadi asumsi ini cukup wajar dipakai sbg fallback,
TAPI belum terverifikasi 100% utk modul-modul ini secara spesifik.

## Belum tertelusuri (arsitektur AJAX beda, bukan soal data kosong)
`coaListing` (Chart of Accounts) — table kosong bahkan di response GET awal, kemungkinan
data dimuat lewat AJAX endpoint terpisah (pola sama dgn `goodsListing`/
`Mpersediaan/getGoodsList`) yang belum ditelusuri. COA jelas ADA datanya (Fixed Assets
`addFa`/`editFaForm` sudah konfirmasi py referensi akun aktif) — ini murni keterbatasan
metode, bukan temuan "kosong".

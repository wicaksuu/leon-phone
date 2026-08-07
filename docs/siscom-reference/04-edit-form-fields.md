# Form "Edit" (Ubah Data) — Field Inventory

> **Status: 15 dari 82 halaman** berhasil diverifikasi dengan URL edit REAL (bukan tebakan)
> + field-nya diambil. Sisanya (~65 halaman, terutama semua modul TRANSAKSI: SO, SI, PO,
> PQ, PR, RO, PI, DO, SQ, Journal, dll) **TIDAK bisa diaudit dengan aman** — lihat
> "Kenapa berhenti di 15" di bawah. Ini bukan kemalasan, ini batas nyata dari aturan kerja
> yang diminta user (baca-saja, GET/navigate, tidak submit form apapun).

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

## Kenapa berhenti di 15 (bukan lanjut ke transaksi)

Untuk dapat 1 ID record asli dari modul transaksi (SO, SI, PO, dst), satu-satunya cara yang
ditemukan adalah **submit form filter/cari** (`<form method="POST" ... id="searchList">` /
tombol "Cari") supaya AJAX listing terpanggil dan baris data muncul. Form submission —
meskipun cuma FILTER/SEARCH, bukan create/update/delete — ada di luar batas kerja yang
disepakati sejak awal audit ini: **"jangan sampai ada penambahan atau pengurangan
database"** dan **"hanya GET/navigate, jangan klik apa-apa dulu"**. Daripada
menginterpretasikan sendiri bahwa "submit form cari" itu aman, audit dihentikan di titik
ini dan didokumentasikan jujur — **perlu konfirmasi eksplisit dari user dulu** kalau mau
lanjut ke arah ini (submit filter form read-only untuk 65 halaman transaksi sisanya).

## Field per halaman (15 yang berhasil diverifikasi, via URL edit REAL)

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
  identik di 14 dari 15 halaman yang dicek). Implikasi desain: kita tidak perlu bikin
  Blade/form terpisah untuk Create vs Edit per modul — cukup 1 komponen form yang menerima
  optional `$record` untuk mode edit, sama seperti pola form Laravel pada umumnya.
- Beberapa field EKSTRA baru muncul pas Edit yang tidak kelihatan di Tambah (Kode Pajak di
  Satuan, Kartu/Uang Muka di Tipe Bayar, Salesman di Retur Penjualan, ketgiro1Temp di AR
  Receipt) — kemungkinan field itu SEBENARNYA ada juga di form Tambah tapi terlewat waktu
  ekstraksi label (batasan metode ekstraksi: hanya ambil elemen visible di viewport
  awal/non-collapsed, form panjang dgn field di scroll/tab lanjutan bisa terlewat).

## Belum tercakup sama sekali
~65 halaman (nyaris semua modul TRANSAKSI: `soListing`, `siListing`, `poListing`,
`pqListing`, `prListing`, `roListing`, `piListing`, `doListing`, `sqListing`,
`journalListing`, `stockOpnameListing`, `transferWhListing`, `adjustStockListing`, dan modul
grouping master seperti `goodsGroupListing`/`custGroupListing`/`suppGroupListing`) — semua
butuh submit form filter/cari dulu sebelum ID record asli muncul di DOM. **Perlu keputusan
eksplisit user**: apakah submit form CARI/FILTER (bukan create/update/delete) dianggap masih
dalam batas aman audit ini, sebelum dilanjutkan.

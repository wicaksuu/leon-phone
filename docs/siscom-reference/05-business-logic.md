# Business Logic — Extracted vs Predicted

> User eksplisit minta: bukan cuma field/tabel yang sama, tapi **LOGIC-nya juga harus
> sama** (`docs/00-status.md` #27) — meski itu artinya sebagian harus diprediksi (audit
> kita read-only, tidak pernah submit transaksi nyata, jadi tidak bisa observasi hasil
> akhir server-side langsung). Dokumen ini pisahkan tegas 2 kategori:
>
> - **EXTRACTED** — logic yang KUTIPAN LANGSUNG dari kode JavaScript client-side yang
>   ketemu di HTML mentah tersimpan (`html/`). SISCOM adalah aplikasi jQuery lama yang
>   render kalkulasi & validasi di browser SEBELUM submit ke server — banyak formula asli
>   ternyata bisa diambil langsung, bukan tebakan. Tiap entri nyantumkan file+nama fungsi
>   sumbernya supaya bisa diverifikasi ulang.
> - **PREDICTED** — logic yang TIDAK ketemu di client-side (murni server-side, atau
>   halaman itu sendiri tidak py JS sama sekali, mis. `addFa`), jadi disimpulkan dari
>   praktik akuntansi/ERP standar + pola SISCOM di tempat lain. Ditandai eksplisit sbg
>   prediksi, BUKAN fakta terverifikasi — perlu diuji ulang begitu ada cara untuk
>   memvalidasi (mis. saat build sendiri, cocokkan hasil dgn ekspektasi user).
>
> **Metode ekstraksi**: cari nama fungsi JS terkait kalkulasi/validasi
> (`hitungTotal`, `cek*`, `otor*`) di file HTML tersimpan, ambil badan fungsi utuh via
> brace-matching, buang array/object literal besar yg isinya data tenant riil (bukan
> logic). Baru ditelusuri sebagian kecil dari total function yg ada di tiap halaman (lihat
> § Belum ditelusuri di bawah) — dokumen ini akan terus bertambah tiap kali logic baru
> digali.

## Pola Approval / Otorisasi — TEMUAN ARSITEKTUR PENTING

**EXTRACTED** (konsisten di `cekMinJual`/`cekStdJual`/`cekStdHargaBeli`, semua halaman
transaksi harga): SISCOM pakai **step-up authorization SINKRON**, BUKAN antrian approval
async. Alurnya:
1. User input harga di luar batas (di bawah Min Jual / di bawah Std Jual / di atas-bawah
   Std Beli) → tombol submit langsung di-disable, muncul warning box.
2. User klik OK pada warning → sistem cek role user saat ini vs level otorisasi minimum
   yg dikonfigurasi (`Utility/getSysdata` dgn kode setting spesifik, mis. `'019'` lalu
   ambil karakter tertentu dari string hasil sbg level angka — konfigurasi granular per
   jenis otorisasi disimpan sbg SATU string, di-substring per posisi).
3. Kalau role user < level yg dibutuhkan → muncul modal LOGIN TERPISAH (User ID +
   Password supervisor, BUKAN sesi user yg sedang login) → di-submit ke endpoint verifikasi
   (`utility/getAccessDefault` atau `utility/verifyUser`, tergantung halaman — penamaan
   endpoint TIDAK konsisten antar modul, kemungkinan ditulis developer berbeda) dgn
   parameter `namaOtorisasi`/`level` spesifik konteks.
4. Verifikasi sukses → submit lanjut otomatis (`simpanData()`/`hitungTotal('add')` dst
   dipanggil langsung dari callback sukses). Verifikasi gagal → tetap terblokir.

**Implikasi desain (perlu diputuskan user)**: desain kita saat ini (`approval_requests`
di `04-database.md`) pakai pola **ASYNC** (request → status pending → approver lain
approve/reject nanti, notifikasi terpisah). SISCOM pakai pola **SYNC** (supervisor
langsung login di tempat, submit lanjut seketika). Dua pola ini py UX & implikasi teknis
beda jauh. **Perlu ditanyakan ke user**: apakah Leon Phone mau ikut pola SISCOM (sync,
supervisor harus di lokasi/available saat itu juga) atau tetap pola async (kasir bisa
lanjut kerja lain, approval masuk antrian)? Kandidat: dukung KEDUANYA (sync utk kasir/
harga real-time, async utk approval yg wajar ditunda spt buka kunci periode).

## Penjualan (SI/Faktur Penjualan) — `hitungTotal` (EXTRACTED, `siscom_addSi.html`)

```
Netto = (Totprice - Discount) + PPN + Ongkos - Poin

Discount = Totprice × DiscPercent / 100
  — auto-terisi kalau customer py "kelompok diskon" aktif & belum expired
    (dicek: tanggal transaksi <= tanggal_expired diskon customer)
PPN = (Totprice - Discount) × PPN% / 100   ← PPN dihitung SETELAH diskon, bukan dari gross
Poin = nilai poin loyalty yang di-redeem, MENGURANGI total akhir
```
`Totprice` sendiri diambil live dari server (`Penjualan/getTotPrice`) berdasarkan detail
item yang sudah diinput — bukan dihitung ulang di client dari nol tiap kali.

**Validasi harga jual** (EXTRACTED, `cekMinJual`/`cekStdJual`):
- Harga jual < **Min Jual** → hard block, submit disabled sampai override (lihat § Pola
  Approval di atas, parameter otorisasi `Otor_MinJual`).
- Harga jual < **Std Jual** (harga standar) → hard block terpisah, override sendiri
  (`Otor_StdJual`) — DUA gate berbeda, bukan 1 pengecekan gabungan. Kalau lolos gate
  Std Jual (baik krn di atas Std Jual, atau krn override berhasil), BARU dicek gate Min
  Jual berikutnya (`cekMinJual` dipanggil dari dalam callback sukses `cekStdJual`).

## Pembelian (PI/Faktur Pembelian, edit) — `cekStdHargaBeli` (EXTRACTED, `siscom_edit_pi.html`)

- Harga beli di atas/bawah **Std Beli** (per satuan — `stdbeli[satuan]`, beda per satuan
  krn Multi Satuan) → hard block, override via login supervisor (endpoint beda dari sisi
  Penjualan: `utility/verifyUser` bukan `getAccessDefault` — SISCOM tidak konsisten
  endpoint-nya, kita boleh unifikasi jadi 1 endpoint approval generik).
- Proyeksi stok setelah transaksi ini (`stokNow`) dihitung dari (stok gudang saat ini,
  dikonversi ke satuan besar via `htgBesar`) dikurangi qty-awal-sebelum-edit ditambah
  qty-baru — kalau proyeksi > **Max Stok** → warning tambahan digabung ke gate yg sama
  (bukan gate terpisah, jadi 1x override menutup kedua alasan sekaligus).

## Penjualan (DO/Delivery Order) — `cekStokGudang` & `overHariLimit` (EXTRACTED, `siscom_addDo.html`)

- **Stok fisik**: item TIDAK BISA ditambah ke DO kalau agregat stok gudang untuk
  barang+group itu ≤ 0, **KECUALI** `tipebarang == '3'` (kemungkinan besar tipe "Jasa"/
  non-fisik, exempt dari cek stok — perlu konfirmasi mapping kode tipe barang lengkap
  saat desain, tapi pola "exempt utk item non-fisik" jelas).
- **Limit kredit customer** (`overHariLimit`, dipanggil sebelum simpan DO):
  ```
  Sisa Limit = Limit + UangMuka(sumum) - SudahDibayar(sumpd)
  ```
  Dua gate terpisah, keduanya HARD BLOCK (bukan warning):
  1. Kalau flag `cklimit` = Y DAN ada piutang customer yg overdue (tanggal transaksi baru
     > tanggal piutang lama yg belum lunas) → blokir TANPA peduli sisa limit (piutang lama
     nunggak = tidak boleh transaksi baru, titik).
  2. Kalau proyeksi total transaksi (`jumlah`) bikin saldo terpakai lewat Sisa Limit →
     blokir juga.
  Kalau kedua gate lolos → `simpanData()` dipanggil, DO tersimpan.

## Penjualan (SR/Retur Penjualan) — `cekImeiExist` (EXTRACTED, `siscom_addSr.html`)

- IMEI yang mau diretur dicek dulu histori-nya (`Penjualan/getImeix2`). **State-machine
  ditemukan**: histori unit py kolom numerik **`FLAG`** yang menggerbang berbagai aksi —
  `FLAG < 6` di konteks retur → error ("belum bisa diretur", kemungkinan unit belum
  sampai status terkirim/delivered). Ini konfirmasi kuat bahwa `serial_units`/
  `serial_unit_histories` kita butuh **status numerik bertingkat** (bukan cuma enum
  kategorikal datar) supaya bisa expressive gate spt ini — kita TIDAK perlu niru angka
  literalnya (6, 8, 5 — lihat juga `cekDoubleImei` di bawah), tapi perlu urutan status yang
  MEMILIKI TOTAL ORDER (received=1 < in_stock=2 < reserved=3 < delivered=4 < sold=5 <
  returned=6 dst, contoh) supaya perbandingan `< threshold` semacam ini bisa direplikasi.
- Kalau IMEI ditemukan tapi terdaftar di **produk BERBEDA** dari yg sedang diinput →
  TIDAK diblokir, cuma popup info + tetap lanjut (soft warning).
- Kalau IMEI **sama sekali tidak ditemukan** di histori → soft warning juga (tanya
  Ya/Tidak lanjut), BUKAN hard block — SISCOM cukup longgar di sini, retur bisa dicatat
  utk IMEI yg sistem sendiri tidak kenali (kemungkinan utk kasus data lama/migrasi).

## Pembelian (RO/Receive) & Persediaan (Adjustment) — `cekDoubleImei` (EXTRACTED)

- Cegah 1 IMEI diinput dobel dalam 1 dokumen yg sama (client-side array `imeiarr`, dicek
  sebelum baris baru ditambah).
- Server-side cross-check via `Pembelian/cekImei` — **threshold FLAG beda per konteks**:
  RO (Receive) pakai `FLAG != '8'` (kemungkinan `8` = kode utk "sudah pernah di-receive"),
  Adjustment pakai `FLAG <= '5'` (kemungkinan unit dgn FLAG ≤5 dianggap "sudah ada di
  stok", jadi tidak boleh di-adjust-masuk lagi). **Konfirmasi tambahan** state-machine
  FLAG numerik dipakai luas, beda modul beda threshold yg relevan — desain kita perlu
  status enum yg cukup granular utk mendukung semua gate ini.

## Pembelian (Retur/PR) — `cekMinimalQty` (EXTRACTED, `siscom_addPr.html`)

Qty retur tidak boleh melebihi stok yg SAAT INI ada di gudang tsb (`Pembelian/getMinQty`)
— hard block (`submitDetail` di-disable), TANPA jalur override eksplisit di fungsi ini
(beda dari gate harga yg semua py jalur override supervisor).

## Akuntansi (Jurnal) — `cek()` (EXTRACTED, `siscom_addJournal.html`)

Simpel: **Cost Centre WAJIB** per baris jurnal (bukan cuma di level akun COA) — kalau
kosong, modal pilih akun otomatis dibuka ulang, submit tertahan. Validasi balance
debit=kredit (`selisih`) dihitung terpisah dari fungsi ini (real-time saat input tiap
baris, sudah tercatat di `03-add-form-fields.md`).

## Aktiva Tetap (Fixed Assets) — **PREDICTED, bukan extracted**

`addFa.html` **TIDAK PUNYA fungsi JavaScript SAMA SEKALI** — depresiasi dihitung murni
server-side, tidak ada preview client-side yg bisa diaudit. Formula di bawah adalah
**PREDIKSI** berdasarkan field yg terlihat (Periode Susut, Penyusutan/Berapa Bulan, Nilai
Buku, Posting DR/CR) + praktik akuntansi standar **garis lurus (straight-line)** — metode
depresiasi paling umum dipakai default di ERP:

```
Depresiasi per Bulan = Nilai Buku Awal / Penyusutan(Berapa Bulan)
Nilai Buku Berjalan = Nilai Buku Awal - (Depresiasi per Bulan × bulan berjalan)
Jurnal otomatis tiap tutup periode: Debit [akun Posting DR] / Kredit [akun Posting CR]
  sebesar Depresiasi per Bulan, sampai Nilai Buku = 0 atau aset dilepas
```
**Tidak terverifikasi** — kalau nanti ada akses ke instance SISCOM lain yg py data Fixed
Assets riil dgn histori depresiasi across periode, atau kalau user py dokumentasi
akuntansi internal Leon Phone soal metode depresiasi yg dipakai, PRIORITASKAN itu di atas
prediksi ini.

## Belum ditelusuri (masih banyak fungsi JS lain per halaman yang belum dibaca)

Baru ~12 fungsi dari puluhan yg ada di tiap halaman transaksi yg diekstrak & didokumentasi
di sini. Fungsi lain yg TERLIHAT ada (dari survey nama fungsi, belum dibaca badannya) tapi
belum diekstrak: `getDpInfo` (logic Uang Muka), `getTermCustomTerm` (termin custom per
customer), `cekStdHargaJual` (base function `cekStdJual` sepertinya manggil ini tapi belum
ketemu definisinya — kemungkinan nama beda/ada di file lain), formula konversi Multi
Satuan (`htgBesar` dipakai tapi definisi konversinya sendiri belum ditelusuri), giro/cheque
lifecycle transition rules, PPN perhitungan versi Pembelian (beda dari Penjualan?), state
transition PENUH untuk `FLAG` numerik (baru tahu beberapa threshold-nya, bukan peta
lengkap 0-N artinya apa).

**Rekomendasi**: gali lebih lanjut kalau/waktu mulai implementasi modul terkait
(`docs/07-roadmap.md`) dan butuh kepastian logic sebelum nulis kode — bukan borong semua
sekarang. Prioritaskan modul yg sedang dikerjakan di fase aktif.

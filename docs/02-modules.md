# 02 — Modules

18 modul, masing-masing = satu folder di `Modules/` (lihat `03-architecture.md`). Urutan di
sini bukan urutan build — urutan build ada di `07-roadmap.md`. Modul #18 (Akuntansi) baru
ditambahkan setelah melihat referensi SISCOM ERP, lihat `docs/00-status.md` #5.

## 1. Dashboard
Ringkasan operasional harian, bukan tempat input data.
- Omzet hari ini, order baru, order belum diproses
- Barang hampir habis (low stock alert), barang paling laris
- Grafik penjualan (harian/mingguan/bulanan)
- Aktivitas karyawan (feed dari audit log)
- Notifikasi marketplace (gagal sinkron, order baru masuk)

## 2. Master Data
Data referensi yang dipakai modul lain. CRUD murni → kandidat kuat untuk Blade+Livewire
table/form (DaisyUI `table` + `form` components) dengan pola standar.
Brand · Kategori · Produk · Varian · **Cabang · Gudang** (hierarki PT → Cabang → Gudang,
lihat `docs/08-tenancy.md`) · Supplier · Customer · Karyawan · Marketplace · Kurir ·
Metode Pembayaran.

## 3. Inventory
**Modul terpenting** — jantung akurasi stok.

- **Barang Masuk**: Purchase Order → Receive Barang → Scan IMEI/Serial Number saat
  terima → Cetak barcode.
- **Stock**, dipecah per dimensi:
  - Per Gudang, Per Rak, Per Marketplace
  - Per status: Reserved · Available · Damaged · Lost
  - Satu unit fisik (via IMEI/Serial Number) hanya boleh berada di satu kombinasi
    gudang+rak+status pada satu waktu — ini invarian yang harus dijaga di level Service,
    bukan cuma di UI.
- **Mutasi**: perpindahan stok Gudang A → Gudang B, punya status pengiriman sendiri
  (dikirim → diterima), bukan langsung pindah instan.
- **Stock Opname**: Scan barcode → sistem hitung selisih vs data → Approval sebelum
  selisih itu benar-benar mengubah stok tercatat.

## 4. Serial Number Management
> Awalnya bernama "IMEI Management" — digeneralisasi (`docs/00-status.md` #18) karena
> toko ini tidak cuma jual HP (IMEI), tapi juga elektronik lain seperti TV/mesin cuci yang
> pakai Serial Number biasa (lihat contoh produk di `ref-gambar/`). IMEI sekarang jadi
> salah satu **tipe identifier**, bukan satu-satunya.

Bukan kolom, tapi **entitas dengan histori penuh** — berlaku untuk setiap barang yang
tiap unit fisiknya perlu dilacak individual (nilai tinggi dan/atau bergaransi per-unit):
```
Unit (IMEI atau Serial Number) → Supplier → Tanggal Masuk → Gudang → Marketplace → Order
  → Customer → Garansi → Retur
```
Scan satu unit = seluruh riwayat langsung muncul (dipakai lintas modul: Inventory, POS,
Warranty, Service, Return, CRM). Detail struktur data → `04-database.md`.

Barang **tanpa** identifier individual (aksesoris, sparepart kecil) TIDAK masuk modul
ini — tetap dilacak agregat by quantity lewat Inventory § Stock di atas.

## 5. Marketplace
Semua marketplace (Shopee, Tokopedia, TikTok, Lazada, Blibli, dst) masuk lewat satu
**Marketplace Engine** sebelum jadi Order:
```
Shopee / Tokopedia / TikTok / Lazada / Blibli → Marketplace Engine → Order
```
Konsekuensi: menambah marketplace baru = menambah satu adapter/integration baru di engine,
**bukan** menambah jalur order baru. Struktur Order tetap satu untuk semua channel (termasuk
offline dari POS Kasir).

## 6. Order Management
Status order lengkap, linear dengan cabang:
```
Draft → Pending Payment → Paid → Picking → Packing → Packed → Waiting Pickup
     → Shipped → Delivered → Completed
```
Status tambahan yang bisa terjadi di titik manapun: `Cancel · Return · Refund · Warranty`.

## 7. POS Kasir
Layar transaksi offline. **Custom Livewire**, bukan CRUD table biasa (butuh kecepatan input
scan berturut-turut). Scan barcode/IMEI/Serial Number · Diskon · Voucher · Member ·
QRIS/Cash/Transfer · Split Payment · Print Thermal · Invoice PDF.

## 8. Packing Station
Halaman khusus admin gudang, **custom Livewire**, alur linear dan ketat:
```
Scan Invoice → Scan Unit (IMEI/Serial Number) → Validasi → Print Resi → Packing → Done
```
Kalau unit yang di-scan tidak cocok dengan yang seharusnya ada di order tersebut → **tidak
bisa lanjut**. Ini validasi keras di level Service, bukan sekadar warning UI.

## 9. Return
Return Marketplace · Return Offline · Garansi · DOA (Dead on Arrival) — semuanya
ditelusuri lewat unit (IMEI/Serial Number), bukan lewat nomor order saja.

## 10. Garansi (Warranty)
```
Waiting → Checking → Claim Vendor → Repair → Done
```

## 11. Service
Servis HP (bukan garansi produk yang dijual toko sendiri, tapi jasa servis umum):
Keluhan · Sparepart · Teknisi · Estimasi biaya · Foto sebelum · Foto sesudah.

## 12. CRM
Customer · Histori pembelian · Histori garansi · Point loyalty · Voucher · Broadcast WA.

## 13. Purchasing
```
Purchase Request → Purchase Order → Receive → Invoice Supplier → Payment
```
(Receive di sini terhubung ke Inventory § Barang Masuk — satu event, dua sisi.)

## 14. Finance
Kas · Bank · Pengeluaran · Pemasukan · Hutang Supplier · Piutang Customer · Cash Flow.

## 15. HR
User · Role · Shift · Absensi (opsional) · Log aktivitas.

## 16. Report
Penjualan · Profit · HPP · Produk Terlaris · Brand Terlaris · Marketplace Terlaris ·
Customer Terbaik · Margin · Cashflow · Stok · Barang Mati · Umur Stok (aging).

## 17. Setting / User
Konfigurasi aplikasi, role & permission per-tenant (dipakai HR juga, lihat
`docs/08-tenancy.md` § Role & permission), preferensi sistem, setting menu per user
(kontrol menu mana yang muncul untuk role tertentu — terlihat di referensi sebagai
"Setting Menu User").

## 18. Akuntansi
**Ditambahkan dari referensi SISCOM ERP** (`docs/00-status.md` #5) — terpisah dari Finance/
Keuangan (§14). Kalau Finance itu operasional kas harian, Akuntansi adalah pembukuan formal:

- **Chart of Accounts (COA)** — daftar akun (aset, kewajiban, modal, pendapatan, beban).
- **Jurnal** — entri jurnal, bisa manual atau otomatis diturunkan dari transaksi modul lain
  (penjualan → jurnal penjualan, pembelian → jurnal pembelian, dst — event-driven, bukan
  input dobel manual).
- **General Ledger (Buku Besar)** — rekap per akun dari seluruh jurnal.
- **Saldo Awal** — saldo pembuka tiap akun saat pertama kali mulai pakai sistem (setup
  sekali, per tenant, per periode awal).
- **Manajemen Periode**: Ganti Periode (pindah periode akuntansi aktif) · Tutup Periode
  (kunci periode yang sudah selesai, tidak bisa diubah lagi tanpa buka kunci) · Buka Kunci
  Data (butuh **Approval Workflow**, lihat fitur lintas-modul di bawah — ini bukan tombol
  bebas, kesalahan di sini bisa merusak laporan keuangan yang sudah dilaporkan) · Validasi
  Data (cek konsistensi saldo sebelum tutup periode).
- Laporan yang dihasilkan modul ini beririsan dengan Report (§16): Neraca, Laba/Rugi
  (sudah disebut spec awal), Arus Kas — bedanya Report menampilkan, Akuntansi yang
  menghasilkan angkanya dari jurnal berbasis double-entry.

---

## Fitur lintas-modul (bukan modul sendiri, tapi wajib ada di semua modul relevan)

- **Audit Log** — setiap perubahan stok/harga/order/user tercatat: siapa, kapan, apa yang
  berubah (before/after).
- **Approval Workflow** — perubahan harga, pembatalan transaksi, retur, stock adjustment
  butuh persetujuan sesuai role.
- **Riwayat Harga** — histori harga beli & harga jual per produk/varian.
- **Label Barcode & QR Code** — cetak label produk dan unit (IMEI/Serial Number).
- **Import/Export Excel** — master data, stok, transaksi.
- **Attachment** — faktur supplier, foto retur, bukti transfer.
- **Notification Center** — stok minimum, order baru, gagal sinkronisasi marketplace.
- **Backup & Restore** — database + file aplikasi.

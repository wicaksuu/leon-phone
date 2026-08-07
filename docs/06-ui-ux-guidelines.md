# 06 — UI/UX Guidelines

Tujuan: semua layar — baik yang dibangkitkan Filament maupun Livewire custom (POS Kasir,
Packing Station) — terasa **satu produk**, bukan tempelan dua sistem berbeda. Kesan:
**modern, premium, responsive** di semua ukuran layar (HP staf gudang, tablet kasir,
desktop admin/owner). Ini prioritas eksplisit dari user, bukan asumsi kami.

## Referensi struktur (bukan referensi gaya visual)

User mengumpulkan screenshot produk sejenis (SISCOM ERP) secara bertahap ke `ref-gambar/`
— log lengkapnya ada di `CLAUDE.md` § Referensi visual (jangan duplikasi log itu di sini,
itu sumber kebenarannya, sinkronkan di sana kalau ada file baru masuk).

**Yang diambil dari referensi**: komposisi/struktur halaman — susunan kartu info, urutan
widget di dashboard, elemen apa yang ada di satu layar (mis. dashboard = kartu info
perusahaan + feed aktivitas + chart best seller + ringkasan keuangan + chart tren).

**Yang TIDAK diambil**: gaya visualnya. Referensi SISCOM dense/klasik ala ERP lama (navy
biru, banyak angka kecil berdempetan, sedikit whitespace) — user eksplisit minta tampilan
didesain **baru**, mengikuti prinsip visual di bawah, bukan ditiru gayanya.

## Prinsip visual

1. **Satu design token, dua permukaan.** Filament theme di-*custom* (bukan default
   out-of-the-box) memakai token Tailwind yang sama dengan layar Livewire custom — warna,
   radius, shadow, spacing scale identik. Token didefinisikan sekali di `tailwind.config.js`
   / CSS variables, dipakai di kedua sisi. Satu codebase Laravel, satu `tailwind.config` —
   tidak ada risiko drift antar build process terpisah.
2. **Premium = whitespace + hierarki tipografi jelas, bukan dekorasi ramai.** Hindari
   gradient berlebihan, shadow bertumpuk, warna terlalu banyak. Palet netral (abu-abu/putih/
   gelap) + satu warna aksen brand + warna semantik (sukses/warning/danger/info) secukupnya.
3. **Dark mode** disiapkan sejak awal (Filament sudah native dukung ini) — bukan
   ditambahkan belakangan. Kasir/gudang sering kerja di ruangan dengan pencahayaan berbeda.
4. **Density sesuai konteks**: layar admin (Filament, Report) boleh lebih padat (banyak data
   per layar, table dense). Layar operasional (POS Kasir, Packing Station) harus **lapang**,
   target sentuh besar (dipakai di tablet/layar sentuh), minim langkah per transaksi.

## Responsive — wajib di semua breakpoint

| Breakpoint | Konteks pemakaian | Yang harus tetap berfungsi penuh |
|---|---|---|
| Mobile (< 640px) | Staf gudang cek stok/scan cepat via HP | Navigasi, scan input, tabel jadi card-list bukan table horizontal-scroll |
| Tablet (640–1024px) | POS Kasir, Packing Station | Layout utama — ini breakpoint prioritas untuk 2 modul ini |
| Desktop (> 1024px) | Admin, owner, back-office | Filament default sudah baik di sini, tetap uji |

Tidak boleh ada layar yang "rusak" (elemen overflow, tombol tak terjangkau, tabel tak
terbaca) di breakpoint manapun sebelum sebuah fitur dianggap selesai.

## Interaksi khusus layar operasional (POS Kasir & Packing Station)

- **Scan-first**: input barcode/IMEI selalu auto-focus, tidak butuh klik dulu.
- **Feedback instan** (< 200ms terasa) untuk tiap scan: sukses (hijau, suara opsional) atau
  gagal (merah, alasan singkat) — tanpa modal yang menghalangi scan berikutnya, kecuali
  memang harus hard-stop (mis. Packing Station § IMEI salah).
- **Keyboard-first di POS Kasir**: shortcut untuk pembayaran cepat, tidak wajib mouse.
- **State tidak boleh hilang** kalau koneksi sempat putus sebentar — Livewire component
  pakai `wire:offline` handling minimal (disable input + pesan jelas), bukan diam-diam
  gagal.

## Komponen bersama

Bangun **satu set komponen Blade/Livewire kecil** yang dipakai ulang di layar custom (button,
badge status, empty state, stat card, scan-input) alih-alih menulis Tailwind mentah berulang
di tiap layar. Filament sudah punya sistem komponennya sendiri — tidak perlu dipaksa seragam
kelas-per-kelas, cukup seragam di *level token* (warna, radius, spacing).

## Checklist "selesai" untuk setiap layar baru

- [ ] Diuji di 3 breakpoint (mobile/tablet/desktop)
- [ ] Dark mode tidak pecah
- [ ] State loading, empty, dan error semua punya tampilan (bukan blank/blank putih)
- [ ] Tidak ada teks/tombol terpotong di ukuran layar manapun yang diuji
- [ ] Warna semantik dipakai konsisten (merah = danger/gagal, hijau = sukses, kuning =
      warning/pending approval)

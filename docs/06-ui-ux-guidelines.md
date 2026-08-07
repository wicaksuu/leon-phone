# 06 — UI/UX Guidelines

Tujuan: seluruh halaman sistem — baik halaman statis Blade, Livewire component biasa, maupun layar operasional interaktif (POS Kasir, Packing Station) — terasa sebagai **satu produk yang kohesif**, modern, premium, dan responsive di semua ukuran layar dengan mengadopsi template **Tailwind-Admin**.

## Struktur Layout Utama (Dashboard & Admin Panel)

Layout utama aplikasi mengadopsi struktur tata letak dari [Tailwind-Admin](https://github.com/Tailwind-Admin/free-tailwind-admin-dashboard-template): **Sidebar Kiri Collapsible + Sticky Top Header**.

```
┌──────────────────────────────────────────────────┐
│                  TOP HEADER/NAVBAR               │
│  [☰ Toggle] [Search] ........... [Notif] [User]  │
├──────────┬───────────────────────────────────────┤
│          │                                       │
│ SIDEBAR  │          MAIN CONTENT AREA            │
│          │                                       │
│ • Logo   │  ┌─────────┐ ┌─────────┐ ┌────────┐   │
│ • Menu   │  │Stat Card│ │Stat Card│ │Stat Card│  │
│ • Groups │  └─────────┘ └─────────┘ └────────┘   │
│ • Sub    │  ┌───────────────────┐ ┌────────────┐ │
│   menus  │  │    Chart Area     │ │  Table/    │ │
│          │  │                   │ │  List      │ │
│          │  └───────────────────┘ └────────────┘ │
│          │                                       │
└──────────┴───────────────────────────────────────┘
```

### 1. Sidebar Kiri (Collapsible & Responsive)
* **Desktop (width >= 1024px)**: Sidebar selalu terbuka di sisi kiri layar dengan lebar tetap (`w-64`). Dapat diciutkan/dikolaps menggunakan tombol toggle untuk memberikan ruang konten yang lebih luas.
* **Mobile/Tablet (width < 1024px)**: Sidebar tersembunyi secara default dan dapat dimunculkan sebagai drawer overlay menggunakan kelas Preline UI `hs-overlay` ketika tombol hamburger di header ditekan.
* **Isi Sidebar**:
  * Brand Logo (Leon Phone) & nama aplikasi di bagian atas.
  * Menu navigasi terstruktur yang dibagi menjadi grup modul (Persediaan, Pembelian, Penjualan, Keuangan, Akunting, Utiliti, dll.).
  * Submenu yang bersifat collapsible menggunakan komponen Accordion/Collapse dari Preline UI.

### 2. Sticky Top Header
* Posisinya tetap di atas (`sticky top-0 z-40`) dengan efek background blur (`backdrop-blur-md bg-white/80 dark:bg-neutral-900/80`) dan border bawah yang tipis.
* **Isi Header**:
  * Tombol hamburger (hanya muncul di mobile/tablet) untuk membuka drawer sidebar.
  * Kolom Pencarian Global (Global Search).
  * **Tenant Switcher (Dropdown)**: Dropdown pilihan PT aktif menggunakan komponen dropdown Preline UI (`hs-dropdown`). Menampilkan nama PT dan kode (misalnya: `PT. ENAM JALAN DEWA ELEKTRONIK (01)`).
  * **Notification Center**: Dropdown dengan ikon lonceng dan badge penanda notifikasi baru.
  * **Theme Switcher**: Tombol toggle untuk berpindah mode Light, Dark, dan System. Mode gelap disinkronkan dengan menambahkan/menghapus kelas `.dark` pada elemen root `<html>`.
  * **User Profile Menu**: Dropdown foto profil/avatar yang berisi informasi akun pengguna, link ke pengaturan password, dan tombol Logout.

### 3. Area Konten Utama (Main Content)
* Pembungkus konten memiliki whitespace premium (`p-4 sm:p-6 space-y-6`).
* Tata letak grid digunakan untuk menyusun kartu informasi statistik (`grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6`).

---

## Referensi Struktur Konten (bukan gaya visual)

Screenshot produk sejenis (SISCOM ERP) di folder `ref-gambar/` dijadikan acuan untuk **komposisi dan kelengkapan konten** di setiap menu, bukan untuk ditiru gaya visualnya (ERP klasik). Tampilan visual kita harus modern, lapang, dan bersih mengikuti desain bawaan Tailwind-Admin.

---

## Prinsip Visual & Theming

1. **Standardisasi Tailwind CSS 4**: Gunakan token warna bawaan dari Tailwind CSS 4. Palet warna didominasi oleh Slate/Neutral untuk latar belakang dan teks, dengan warna Indigo/Blue sebagai warna aksen utama (Primary).
2. **Penggunaan Mode Gelap (Dark Mode)**: Mode gelap didukung penuh menggunakan utilitas kelas `dark:` di Tailwind. Latar belakang kontainer bertransisi menjadi warna gelap (misalnya `dark:bg-neutral-900` atau `dark:bg-neutral-800`), dan teks menjadi putih keabu-abuan.
3. **Kepadatan Informasi (Density)**:
   * **Halaman CRUD & Back-Office (Akuntansi, Pembelian, dll.)**: Kepadatan sedang hingga tinggi. Tabel menggunakan padding kecil agar informasi baris data muat lebih banyak dalam satu layar.
   * **Layar Operasional (POS Kasir, Packing Station)**: Kepadatan rendah dengan elemen antarmuka yang besar (tombol besar, input besar) untuk memudahkan penekanan pada perangkat tablet atau layar sentuh.

---

## Responsive Breakpoints

| Breakpoint | Konteks Pemakaian | Target Responsivitas |
|---|---|---|
| Mobile (< 640px) | Staf gudang cek stok / scan via HP | Sidebar tersembunyi. Tabel lebar diubah menjadi daftar kartu (card list). Target klik berukuran minimal 44x44px. |
| Tablet (640–1024px) | POS Kasir, Packing Station | Sidebar tersembunyi. Grid kasir tersusun optimal dalam orientasi lanskap. |
| Desktop (> 1024px) | Admin, owner, back-office | Sidebar terbuka secara default. Konten melebar penuh dengan visual grid dashboard yang komprehensif. |

---

## Interaksi Khusus Layar Operasional (POS Kasir & Packing Station)

* **Scan-first**: Input barcode/IMEI/Serial Number selalu difokuskan secara otomatis (`autofocus` + JavaScript refokus setelah interaksi).
* **Feedback Instan**: Gunakan notifikasi melayang (Toast) di pojok kanan bawah yang digerakkan oleh Livewire/JavaScript dengan transisi mulus dan indikator semantik (sukses = hijau, error = merah).
* **Keyboard Shortcuts**: Kasir dapat menyelesaikan transaksi menggunakan shortcut keyboard (misal: F8 untuk pembayaran, F9 untuk cetak) tanpa memegang mouse.

---

## Komponen Bersama (Preline UI Kit)

Kita memaksimalkan penggunaan komponen bawaan **Preline UI** untuk menjaga konsistensi:
* **Buttons**: Tombol menggunakan utility class Tailwind standar dengan padding yang pas dan radius medium (misalnya `py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none`).
* **Badges**: Label status menggunakan badge kecil dengan sudut membulat penuh (`inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500`).
* **Cards**: Kontainer info bertipe borderless atau border tipis dengan shadow tipis (`flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70`).
* **Tables**: Zebra stripe table minimalis (`min-w-full divide-y divide-gray-200 dark:divide-neutral-700`).
* **Modals**: Komponen modal responsif dari Preline UI yang menyertakan atribut `data-hs-overlay` untuk pembukaan dan penutupan yang mulus.
* **Dropdowns**: Dropdown menu menggunakan kelas `hs-dropdown` untuk penanganan posisi dan interaksi klik di luar elemen secara otomatis.

---

## Checklist Kelayakan Layar Baru

* [ ] Diuji dan tidak overflow di 3 breakpoint (mobile/tablet/desktop).
* [ ] Tampilan kontras dan tidak pecah saat berganti tema Light/Dark.
* [ ] Memiliki visual state yang jelas untuk: Loading (spinner/skeleton), Empty State, dan Error State.
* [ ] Tombol aksi di mobile/tablet memiliki area klik yang cukup (minimal 44x44px).
* [ ] Konsisten menggunakan warna semantik (hijau = success, merah = error).

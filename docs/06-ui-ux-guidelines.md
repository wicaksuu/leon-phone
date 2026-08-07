# 06 — UI/UX Guidelines

Tujuan: seluruh halaman sistem — baik halaman statis Blade, Livewire component biasa, maupun layar operasional interaktif (POS Kasir, Packing Station) — terasa sebagai **satu produk yang kohesif**, modern, premium, dan responsive di semua ukuran layar.

## Struktur Layout Utama (Dashboard & Admin Panel)

Layout utama aplikasi mengadopsi pola **Drawer-based Sidebar + Top Header/Navbar** terinspirasi langsung dari [DaisyUI Nexus Dashboard Growth](https://nexus.daisyui.com/dashboards/growth).

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

### 1. Drawer-based Sidebar (DaisyUI `drawer` & `menu`)
- **Desktop (width >= 1024px)**: Sidebar selalu terbuka menggunakan class `.lg:drawer-open`. Sidebar berada di sisi kiri layar dengan lebar tetap (misalnya `w-64` atau `w-80`).
- **Mobile/Tablet (width < 1024px)**: Sidebar tersembunyi secara default dan dapat dimunculkan sebagai drawer overlay saat pengguna menekan tombol menu (hamburger) pada header.
- **Isi Sidebar**:
  - Brand Logo & nama aplikasi di bagian atas.
  - Navigasi utama terstruktur menggunakan DaisyUI `menu` component.
  - Collapsible submenus (`details` / `summary` native tag dengan style DaisyUI) untuk mengelompokkan menu yang memiliki banyak submenu (seperti grup "Utiliti" atau "Master Data").

### 2. Top Header/Navbar (DaisyUI `navbar`)
- Sisi atas konten (`.drawer-content`), dengan posisi sticky (`.sticky .top-0 .z-30`) dan background semi-transparan (`.bg-base-100/80 .backdrop-blur`).
- **Isi Header**:
  - Tombol toggle drawer (hamburger button) di pojok kiri (hanya muncul di mobile/tablet).
  - Global Search bar (opsional, input statis).
  - **Tenant Switcher (Dropdown)**: Dropdown pilihan PT aktif menggunakan DaisyUI `dropdown` component. Menampilkan nama PT dan kode (misalnya: `PT. ENAM JALAN DEWA ELEKTRONIK (01)`).
  - **Notification Center**: Dropdown bell icon dengan indikator angka notifikasi belum dibaca.
  - **Theme Controller**: Toggle / dropdown untuk berpindah tema (Light/Dark/System).
  - **User Profile Menu**: Dropdown avatar yang berisi link profil, pengaturan password, dan tombol Logout.

### 3. Main Content Area (`.drawer-content` / `.p-6`)
- Content wrapper memiliki padding yang cukup (`p-4 md:p-6 lg:p-8`) untuk memberikan whitespace premium.
- Layout halaman dashboard menggunakan CSS Grid (`grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6`) untuk menyusun statistik secara responsive.

---

## Referensi Struktur Konten (bukan gaya visual)

Screenshot produk sejenis (SISCOM ERP) di folder `ref-gambar/` dijadikan acuan untuk **komposisi dan kelengkapan konten** di setiap menu, bukan untuk ditiru gaya visualnya (ERP klasik). Tampilan visual kita harus modern, lapang, dan bersih.

---

## Prinsip Visual & Theming

1. **DaisyUI Semantic Color Tokens**: Hindari menaruh warna hard-coded (seperti `bg-blue-600` atau `text-red-500`) secara langsung untuk komponen UI utama. Gunakan utility warna DaisyUI yang dinamis:
   - Warna Utama: `bg-primary`, `text-primary-content`
   - Warna Latar: `bg-base-100` (halaman utama), `bg-base-200` (sidebar/background utama), `bg-base-300` (card/hover element)
   - Status Semantik: `alert-success`, `alert-warning`, `alert-error`, `alert-info`
2. **Premium Whitespace**: Whitespace (ruang kosong) adalah elemen desain kelas satu. Gunakan padding (`p-6`) dan gap (`gap-6`) yang memadai untuk memisahkan data-heavy elements agar tidak terkesan bertumpuk dan sesak.
3. **Responsive Dark Mode**: Dark mode didukung secara bawaan melalui framework DaisyUI. Pengaturan tema dilakukan dengan memasang atribut `data-theme` pada root tag `<html>` (misal: `data-theme="light"` atau `data-theme="dark"`).
4. **Density Sesuai Konteks**:
   - Layar Back-Office (CRUD, Akuntansi, Report): Density sedang, tabel menggunakan styling compact (`table-sm` atau `table-xs`) agar data terlihat dalam jumlah banyak tanpa scroll berlebih.
   - Layar Operasional (POS Kasir, Packing Station): Density lapang, input dan target sentuh berukuran besar (`btn-lg`, `input-lg`) karena sering diakses melalui tablet/layar sentuh.

---

## Responsive Breakpoints

| Breakpoint | Konteks Pemakaian | Target Responsivitas |
|---|---|---|
| Mobile (< 640px) | Staf gudang cek stok / scan via HP | Sidebar terlipat. Tabel dikonversi menjadi layout card-list. Tombol aksi berada di posisi yang mudah dijangkau satu tangan. |
| Tablet (640–1024px) | POS Kasir, Packing Station | Layout dashboard flex-col/grid menyesuaikan layar medium. Lebar layout kasir tetap optimal untuk mode landscape. |
| Desktop (> 1024px) | Admin, owner, back-office | Sidebar terbuka (`lg:drawer-open`). Grid card statistik terbentang penuh (grid-cols-4). |

---

## Interaksi Khusus Layar Operasional (POS Kasir & Packing Station)

- **Scan-first**: Input barcode/IMEI/Serial Number selalu difokuskan secara otomatis (`autofocus` + JavaScript refokus setelah interaksi).
- **Feedback Instan**: Gunakan notifikasi DaisyUI `toast` dengan alert semantik (hijau sukses, merah gagal) yang melayang di pojok kanan bawah. Feedback harus muncul kurang dari 200ms setelah input ter-trigger.
- **Keyboard Shortcuts**: Kasir dapat menyelesaikan transaksi menggunakan shortcut keyboard (misal: F8 untuk pembayaran, F9 untuk cetak) tanpa memegang mouse.

---

## Komponen Bersama (DaisyUI UI Kit)

Kita memaksimalkan penggunaan komponen bawaan DaisyUI 5 untuk menjaga konsistensi:
- **Button**: `.btn .btn-primary` (utama), `.btn .btn-outline` (sekunder), `.btn .btn-error` (batal/hapus).
- **Badge**: `.badge .badge-success` (aktif/selesai), `.badge .badge-warning` (pending).
- **Card**: `.card .bg-base-100 .shadow-xl` untuk kontainer konten atau grafik.
- **Table**: `.table .table-zebra` untuk listing data.
- **Modal**: `.modal` yang dipadukan dengan Javascript/Livewire untuk form dialog interaktif.
- **Notification/Toast**: `.toast` berisi `.alert` untuk pesan alert dinamis.

---

## Checklist Kelayakan Layar Baru

- [ ] Diuji dan tidak overflow di 3 breakpoint (mobile/tablet/desktop).
- [ ] Tampilan kontras dan tidak pecah saat berganti tema Light/Dark.
- [ ] Memiliki visual state yang jelas untuk: Loading (`loading` spinner), Empty State, dan Error State.
- [ ] Tombol aksi di mobile/tablet memiliki area klik yang cukup (minimal 44x44px).
- [ ] Konsisten menggunakan semantic color tokens (hijau = success, merah = error).

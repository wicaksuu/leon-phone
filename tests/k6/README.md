# k6 load tests

Wajib untuk aksi frekuensi tinggi (`docs/05-coding-standards.md` § 4c): POS checkout, scan
IMEI (Packing Station & Receive Barang), search produk/varian, sinkronisasi marketplace.
Belum ada skrip untuk endpoint-endpoint itu karena endpoint-nya sendiri belum dibangun
(Fase 2+) — jangan tulis skrip k6 untuk endpoint yang belum ada, tulis begitu endpoint-nya
dibangun, di PR yang sama.

## Konvensi

- Satu file per aksi: `tests/k6/<modul>/<nama-aksi>.js` (mis. `tests/k6/pos/checkout.js`).
- Threshold p95 latency disepakati & dicatat sebagai komentar di skrip saat endpoint-nya
  dibangun — jangan didiamkan sebagai magic number tanpa penjelasan.
- Helper bersama (base URL, auth header, dll) di `tests/k6/_shared/`.
- Jalan manual (`k6 run tests/k6/<path>.js`) atau di CI terjadwal — **bukan** tiap PR,
  terlalu berat untuk itu.

## Contoh yang bisa dijalankan sekarang

`tests/k6/_shared/smoke.js` — hit endpoint health-check bawaan Laravel (`/up`). Ini bukan
load test fitur bisnis (belum ada fiturnya), tapi contoh format skrip k6 yang valid dan
langsung bisa dijalankan untuk verifikasi setup k6 itu sendiri:

```bash
k6 run tests/k6/_shared/smoke.js
```

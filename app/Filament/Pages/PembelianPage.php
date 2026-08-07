<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

/**
 * Placeholder navigasi (docs/00-status.md #17) — isi sebenarnya dibangun
 * sesuai urutan docs/07-roadmap.md, bukan sekarang. Halaman ini hanya
 * memastikan struktur sidebar sudah sesuai referensi (ref-gambar/) sejak
 * awal.
 */
class PembelianPage extends Page
{
    protected string $view = 'filament.pages.pembelian';

    protected static ?string $slug = 'pembelian';

    protected static string|\UnitEnum|null $navigationGroup = 'Pembelian';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Pembelian';

    protected static ?int $navigationSort = 40;

    protected static ?string $title = 'Pembelian';
}

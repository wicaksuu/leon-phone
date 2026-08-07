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
class PenjualanPage extends Page
{
    protected string $view = 'filament.pages.penjualan';

    protected static ?string $slug = 'penjualan';

    protected static string|\UnitEnum|null $navigationGroup = 'Penjualan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Penjualan';

    protected static ?int $navigationSort = 60;

    protected static ?string $title = 'Penjualan';
}

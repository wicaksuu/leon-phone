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
class LaporanPage extends Page
{
    protected string $view = 'filament.pages.laporan';

    protected static ?string $slug = 'laporan';

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?int $navigationSort = 170;

    protected static ?string $title = 'Laporan';
}

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
class PackingStationPage extends Page
{
    protected string $view = 'filament.pages.packing-station';

    protected static ?string $slug = 'packing-station';

    protected static string|\UnitEnum|null $navigationGroup = null;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationLabel = 'Packing Station';

    protected static ?int $navigationSort = 80;

    protected static ?string $title = 'Packing Station';
}

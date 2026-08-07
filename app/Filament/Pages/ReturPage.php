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
class ReturPage extends Page
{
    protected string $view = 'filament.pages.retur';

    protected static ?string $slug = 'retur';

    protected static string|\UnitEnum|null $navigationGroup = 'Retur';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?string $navigationLabel = 'Retur';

    protected static ?int $navigationSort = 90;

    protected static ?string $title = 'Retur';
}

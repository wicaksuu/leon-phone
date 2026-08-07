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
class GantiPeriodePage extends Page
{
    protected string $view = 'filament.pages.ganti-periode';

    protected static ?string $slug = 'ganti-periode';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Ganti Periode';

    protected static ?int $navigationSort = 230;

    protected static ?string $title = 'Ganti Periode';
}

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
class TutupPeriodePage extends Page
{
    protected string $view = 'filament.pages.tutup-periode';

    protected static ?string $slug = 'tutup-periode';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-lock-closed';

    protected static ?string $navigationLabel = 'Tutup Periode';

    protected static ?int $navigationSort = 240;

    protected static ?string $title = 'Tutup Periode';
}

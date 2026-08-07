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
class HrPage extends Page
{
    protected string $view = 'filament.pages.hr';

    protected static ?string $slug = 'hr';

    protected static string|\UnitEnum|null $navigationGroup = 'HR';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'HR';

    protected static ?int $navigationSort = 160;

    protected static ?string $title = 'HR';
}

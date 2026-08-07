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
class GaransiPage extends Page
{
    protected string $view = 'filament.pages.garansi';

    protected static ?string $slug = 'garansi';

    protected static string|\UnitEnum|null $navigationGroup = 'Garansi';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Garansi';

    protected static ?int $navigationSort = 100;

    protected static ?string $title = 'Garansi';
}

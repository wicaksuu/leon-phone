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
class ServisPage extends Page
{
    protected string $view = 'filament.pages.servis';

    protected static ?string $slug = 'servis';

    protected static string|\UnitEnum|null $navigationGroup = 'Servis';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Servis';

    protected static ?int $navigationSort = 110;

    protected static ?string $title = 'Servis';
}

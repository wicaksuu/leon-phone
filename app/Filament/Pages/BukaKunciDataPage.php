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
class BukaKunciDataPage extends Page
{
    protected string $view = 'filament.pages.buka-kunci-data';

    protected static ?string $slug = 'buka-kunci-data';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-lock-open';

    protected static ?string $navigationLabel = 'Buka Kunci Data';

    protected static ?int $navigationSort = 250;

    protected static ?string $title = 'Buka Kunci Data';
}

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
class PosKasirPage extends Page
{
    protected string $view = 'filament.pages.pos-kasir';

    protected static ?string $slug = 'pos-kasir';

    protected static string|\UnitEnum|null $navigationGroup = null;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'POS Kasir';

    protected static ?int $navigationSort = 70;

    protected static ?string $title = 'POS Kasir';
}

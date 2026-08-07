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
class ValidasiDataPage extends Page
{
    protected string $view = 'filament.pages.validasi-data';

    protected static ?string $slug = 'validasi-data';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationLabel = 'Validasi Data';

    protected static ?int $navigationSort = 260;

    protected static ?string $title = 'Validasi Data';
}

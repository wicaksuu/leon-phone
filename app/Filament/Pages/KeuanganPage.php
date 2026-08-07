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
class KeuanganPage extends Page
{
    protected string $view = 'filament.pages.keuangan';

    protected static ?string $slug = 'keuangan';

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Keuangan';

    protected static ?int $navigationSort = 130;

    protected static ?string $title = 'Keuangan';
}

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
class PersediaanPage extends Page
{
    protected string $view = 'filament.pages.persediaan';

    protected static ?string $slug = 'persediaan';

    protected static string|\UnitEnum|null $navigationGroup = 'Persediaan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Persediaan';

    protected static ?int $navigationSort = 20;

    protected static ?string $title = 'Persediaan';
}

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
class AkuntansiPage extends Page
{
    protected string $view = 'filament.pages.akuntansi';

    protected static ?string $slug = 'akuntansi';

    protected static string|\UnitEnum|null $navigationGroup = 'Akuntansi';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Akuntansi';

    protected static ?int $navigationSort = 140;

    protected static ?string $title = 'Akuntansi';
}

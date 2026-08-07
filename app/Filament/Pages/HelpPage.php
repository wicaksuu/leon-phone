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
class HelpPage extends Page
{
    protected string $view = 'filament.pages.help';

    protected static ?string $slug = 'help';

    protected static string|\UnitEnum|null $navigationGroup = null;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Help';

    protected static ?int $navigationSort = 999;

    protected static ?string $title = 'Help';
}

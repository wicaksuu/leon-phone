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
class SettingDefaultPage extends Page
{
    protected string $view = 'filament.pages.setting-default';

    protected static ?string $slug = 'setting-default';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Setting Default';

    protected static ?int $navigationSort = 190;

    protected static ?string $title = 'Setting Default';
}

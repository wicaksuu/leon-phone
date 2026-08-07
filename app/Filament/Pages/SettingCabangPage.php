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
class SettingCabangPage extends Page
{
    protected string $view = 'filament.pages.setting-cabang';

    protected static ?string $slug = 'setting-cabang';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Setting Cabang';

    protected static ?int $navigationSort = 180;

    protected static ?string $title = 'Setting Cabang';
}

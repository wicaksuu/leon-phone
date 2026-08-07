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
class ImeiManagementPage extends Page
{
    protected string $view = 'filament.pages.imei-management';

    protected static ?string $slug = 'imei-management';

    protected static string|\UnitEnum|null $navigationGroup = null;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'IMEI Management';

    protected static ?int $navigationSort = 30;

    protected static ?string $title = 'IMEI Management';
}

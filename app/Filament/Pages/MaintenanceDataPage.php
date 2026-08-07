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
class MaintenanceDataPage extends Page
{
    protected string $view = 'filament.pages.maintenance-data';

    protected static ?string $slug = 'maintenance-data';

    protected static string|\UnitEnum|null $navigationGroup = 'Utiliti';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $navigationLabel = 'Maintenance Data';

    protected static ?int $navigationSort = 220;

    protected static ?string $title = 'Maintenance Data';
}

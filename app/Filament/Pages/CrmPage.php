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
class CrmPage extends Page
{
    protected string $view = 'filament.pages.crm';

    protected static ?string $slug = 'crm';

    protected static string|\UnitEnum|null $navigationGroup = 'CRM';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'CRM';

    protected static ?int $navigationSort = 120;

    protected static ?string $title = 'CRM';
}

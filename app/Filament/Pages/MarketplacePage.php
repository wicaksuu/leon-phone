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
class MarketplacePage extends Page
{
    protected string $view = 'filament.pages.marketplace';

    protected static ?string $slug = 'marketplace';

    protected static string|\UnitEnum|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Marketplace';

    protected static ?int $navigationSort = 50;

    protected static ?string $title = 'Marketplace';
}

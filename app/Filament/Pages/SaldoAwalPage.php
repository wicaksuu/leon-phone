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
class SaldoAwalPage extends Page
{
    protected string $view = 'filament.pages.saldo-awal';

    protected static ?string $slug = 'saldo-awal';

    protected static string|\UnitEnum|null $navigationGroup = 'Saldo Awal';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationLabel = 'Saldo Awal';

    protected static ?int $navigationSort = 150;

    protected static ?string $title = 'Saldo Awal';
}

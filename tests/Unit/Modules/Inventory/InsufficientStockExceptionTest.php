<?php

namespace Tests\Unit\Modules\Inventory;

use Modules\Inventory\Exceptions\InsufficientStockException;
use Modules\Shared\Exceptions\DomainException;
use PHPUnit\Framework\TestCase;

/**
 * Pure unit test — no DB, no HTTP. Proves the exception's own contract
 * (message, HTTP status, machine-readable code) in isolation, per
 * docs/05-coding-standards.md § 4a.
 */
class InsufficientStockExceptionTest extends TestCase
{
    public function test_it_is_a_domain_exception(): void
    {
        $exception = new InsufficientStockException('iPhone 15 128GB', requested: 3, available: 1);

        $this->assertInstanceOf(DomainException::class, $exception);
    }

    public function test_it_reports_available_and_requested_quantities_in_the_message(): void
    {
        $exception = new InsufficientStockException('iPhone 15 128GB', requested: 3, available: 1);

        $this->assertSame(
            'Stok iPhone 15 128GB tidak cukup: diminta 3, tersedia 1.',
            $exception->getMessage(),
        );
    }

    public function test_it_maps_to_a_409_conflict_status(): void
    {
        $exception = new InsufficientStockException('iPhone 15 128GB', requested: 3, available: 1);

        $this->assertSame(409, $exception->status());
    }

    public function test_it_has_a_stable_machine_readable_code(): void
    {
        $exception = new InsufficientStockException('iPhone 15 128GB', requested: 3, available: 1);

        $this->assertSame('insufficient_stock_exception', $exception->code());
    }
}

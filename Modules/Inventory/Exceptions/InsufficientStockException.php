<?php

namespace Modules\Inventory\Exceptions;

use Modules\Shared\Exceptions\DomainException;

final class InsufficientStockException extends DomainException
{
    public function __construct(string $productVariant, int $requested, int $available)
    {
        parent::__construct("Stok {$productVariant} tidak cukup: diminta {$requested}, tersedia {$available}.");
    }

    public function status(): int
    {
        return 409;
    }
}

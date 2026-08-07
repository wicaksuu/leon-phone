<?php

namespace Modules\Shared\Exceptions;

use Exception;
use Illuminate\Support\Str;

/**
 * Base class for every business-rule exception in the app
 * (docs/05-coding-standards.md § 1). Never throw this directly — throw a
 * named subclass per module (e.g. InsufficientStockException) so the
 * Handler in bootstrap/app.php and callers can distinguish failure modes.
 */
abstract class DomainException extends Exception
{
    /**
     * HTTP status this exception should map to when rendered as JSON
     * (API/webhook) — see bootstrap/app.php. Subclasses override this for
     * anything other than a generic validation-style failure.
     */
    public function status(): int
    {
        return 422;
    }

    /**
     * Machine-readable code for API consumers. Defaults to the short class
     * name in snake_case; override when a stable, decoupled code is needed.
     */
    public function code(): string
    {
        return Str::snake(class_basename($this));
    }
}

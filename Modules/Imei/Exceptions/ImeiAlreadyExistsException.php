<?php

namespace Modules\Imei\Exceptions;

use Modules\Shared\Exceptions\DomainException;

final class ImeiAlreadyExistsException extends DomainException
{
    public function __construct(string $imei)
    {
        parent::__construct("IMEI {$imei} sudah terdaftar di sistem.");
    }

    public function status(): int
    {
        return 409;
    }
}

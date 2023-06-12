<?php

declare(strict_types=1);

namespace Entity\Exception;

use OutOfBoundsException;
use Throwable;

class EntityNotFoundException extends OutOfBoundsException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

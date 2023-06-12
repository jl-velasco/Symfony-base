<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Exception;

use Exception;

class InvalidTypeException extends Exception
{
    public function __construct(string $expectedType, string $actualType)
    {
        parent::__construct("Invalid type, expected: {$expectedType}, got: {$actualType}");
    }

}

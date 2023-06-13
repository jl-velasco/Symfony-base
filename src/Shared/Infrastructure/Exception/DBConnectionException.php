<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Exception;

use Exception;

class DBConnectionException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('DB connection failed: %s', $message));
    }
}

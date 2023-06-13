<?php

namespace Symfony\Base\Shared\Infrastructure\Exceptions;

class SqlConnectionException extends \Exception
{
    public function __construct(\Exception $e)
    {
        $message =
            sprintf("Database connection error: %s (%s)",
                $e->getMessage(),
                $e->getCode()
            );
        parent::__construct($message, $e->code);
    }
}

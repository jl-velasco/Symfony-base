<?php

namespace Symfony\Base\Shared\Domain;

final class InternalErrorException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
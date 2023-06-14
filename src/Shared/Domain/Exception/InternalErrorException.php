<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Exception;

final class InternalErrorException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
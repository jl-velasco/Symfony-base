<?php

namespace Symfony\Base\Shared\Infrastructure\Exceptions;

use Doctrine\DBAL\Exception;

class VideoNotConnectDBException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Video with problem connect databas, %s', $id));
    }
}

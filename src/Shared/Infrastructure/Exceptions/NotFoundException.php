<?php

namespace Symfony\Base\Shared\Infrastructure\Exceptions;

use Symfony\Component\Config\Definition\Exception\Exception;

class NotFoundException extends Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct(sprintf('Not found Video, %s', $string));
    }
}

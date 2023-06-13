<?php
declare(strict_types = 1);

namespace Symfony\Base\Shared\Infraestructure\Exceptions;

class DatabaseException extends \Exception
{
    public function __construct()
    {
        parent::__construct(sprintf('Database error'));
    }
}
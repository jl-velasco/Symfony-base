<?php
declare(strict_types = 1);

namespace Symfony\Base\Registation\Domain\Exceptions;

class UserNotExistException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('User with id <%s> not exist', $id));
    }
}
<?php
declare(strict_types=1);

namespace Symfony\Base\User\Dominio;

use Symfony\Base\Shared\ValueObject\StringValueObject;
use Symfony\Base\User\Dominio\Exceptions\PasswordIncorrectException;

class Password extends StringValueObject
{
    public function __construct(string $value = '')
    {
        if ($value == '')
            throw new PasswordIncorrectException("Cannot create the user without password");
        parent::__construct($value);
    }
}

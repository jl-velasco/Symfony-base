<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\ValueObject;

use Symfony\Base\Shared\Domain\Exceptions\InvalidEmailException;

class Email extends StringValueObject
{
    public function __construct(protected string $value)
    {
        if (!Email::validate($value))
            throw new InvalidEmailException("Email format is incorrect");
        parent::__construct($value);
    }

    public static function validate($email): bool
    {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

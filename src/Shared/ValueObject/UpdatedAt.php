<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;

class UpdatedAt extends DateTimeValueObject
{
    static function fromPrimitive($dateTime = '') {
        return new self(new \DateTime($dateTime));
    }
}

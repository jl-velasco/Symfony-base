<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\ValueObject;

class CreatedAt extends DateTimeValueObject
{
    static function fromPrimitive($dateTime = '') {
        return new self(new \DateTime($dateTime));
    }
}

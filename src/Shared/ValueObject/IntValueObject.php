<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

abstract class IntValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->value() > $other->value();
    }
}

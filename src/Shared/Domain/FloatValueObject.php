<?php

declare(strict_types=1);

namespace CGE\Member\Shared\Domain;

use Symfony\Base\Shared\Domain\ValueObject;

abstract class FloatValueObject extends ValueObject
{
    public function __construct(protected float $value)
    {
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function value(): float
    {
        return $this->value;
    }
}

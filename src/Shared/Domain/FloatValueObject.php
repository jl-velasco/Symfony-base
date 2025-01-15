<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

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

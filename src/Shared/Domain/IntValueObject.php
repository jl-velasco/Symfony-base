<?php

namespace Symfony\Base\Shared\Domain;

abstract class IntValueObject extends ValueObject
{
    public function __construct(public readonly int $value)
    {
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function biggerThan(IntValueObject $other): bool
    {
        return $this->value > $other->value;
    }

    public function smallerThan(IntValueObject $other): bool
    {
        return $this->value < $other->value;
    }

    public function value(): int
    {
        return $this->value;
    }
}

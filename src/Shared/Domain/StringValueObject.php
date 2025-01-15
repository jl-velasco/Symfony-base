<?php

namespace Symfony\Base\Shared\Domain;

abstract class StringValueObject extends ValueObject
{
    public function __construct(protected string $value = '')
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }
}

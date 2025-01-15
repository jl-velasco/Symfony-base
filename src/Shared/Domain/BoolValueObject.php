<?php

namespace Symfony\Base\Shared\Domain;

abstract class BoolValueObject extends ValueObject
{
    public function __construct(protected bool $value)
    {
    }

    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    public function value(): bool
    {
        return $this->value;
    }
}

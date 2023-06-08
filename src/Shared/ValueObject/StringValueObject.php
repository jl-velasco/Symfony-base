<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

abstract class StringValueObject
{
    public function __construct(protected string $value = '')
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

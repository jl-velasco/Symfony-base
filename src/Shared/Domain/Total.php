<?php

namespace Symfony\Base\Shared\Domain;


class Total extends FloatValueObject
{
    public function sum(float $total): static
    {
        return new static($this->value() + $total);
    }

    public function sub(float $value): static
    {
        return new static($this->value() - $value);
    }
}
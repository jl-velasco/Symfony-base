<?php

namespace Symfony\Base\Shared\Domain;


class Total extends FloatValueObject
{
    public function sum(float $total): self
    {
        return new self($this->value() + $total);
    }

    public function sub(float $value): self
    {
        return new self($this->value() - $value);
    }
}
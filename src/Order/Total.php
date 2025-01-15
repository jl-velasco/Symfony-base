<?php

namespace Symfony\Base\Order;

use CGE\Member\Shared\Domain\FloatValueObject;

class Total extends FloatValueObject
{
    public function sum(float $total): self
    {
        return new self($this->value() + $total);
    }
}
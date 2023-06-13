<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

abstract class DateTimeValueObject
{
    public function __construct(protected ?\DateTime $value)
    {
        if (!$this->value)
            $this->value = new \DateTime();
    }

    public function value(): \DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format("Y-m-d H:i:s");
    }
}

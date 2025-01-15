<?php

namespace Symfony\Base\Coche;

class CocheDistance
{
    public function __construct(
        public float $distance,
        public DistanceUnits $unit
    )
    {
    }

    public function value(): float
    {
        return $this->distance . $this->unit->name;
    }

    public function validate(): void
    {
        //valdation
    }

    public function equals(CocheDistance $other): bool
    {
        return $this === $other;
    }

    public function sum(float $distance): self
    {
        return new self($this->distance + $distance, $this->unit);
    }
}
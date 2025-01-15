<?php

namespace Symfony\Base\Shared\Domain;

class Coordenates
{
    public function __construct(
        protected float $latitude,
        protected float $longitude
    )
    {
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function equals(Coordenates $other): bool
    {
        return $this->latitude() === $other->latitude() && $this->longitude() === $other->longitude();
    }

    public function value(): string
    {
        return $this->latitude() . ', ' . $this->longitude();
    }
}
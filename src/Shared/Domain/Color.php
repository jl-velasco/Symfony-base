<?php

namespace Symfony\Base\Shared\Domain;

class Color
{
    public function __construct(
        protected string $value
    )
    {
        $this->validate();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function validate(): void
    {
        // Logica para lo que sea
    }

    public function equals(Color $other): bool
    {
        return $this === $other;
    }
}
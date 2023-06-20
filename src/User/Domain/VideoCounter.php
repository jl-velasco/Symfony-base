<?php

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\ValueObject\IntValueObject;

class VideoCounter extends IntValueObject
{
    public function __construct(int $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    public function increase(): self
    {
        return new self($this->value() + 1);
    }

    public function decrease(): self
    {
        return new self($this->value() - 1);
    }

    private function validate(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Value cannot be less than 0');
        }
    }
}
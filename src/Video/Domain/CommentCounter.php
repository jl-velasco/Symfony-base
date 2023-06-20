<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\IntValueObject;

class CommentCounter extends IntValueObject
{
    public function __construct(int $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    public function increment(): self
    {
        return new self($this->value() + 1);
    }

    public function decrement(): self
    {
        return new self($this->value() - 1);
    }

    private function validate(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Invalid count provided.');
        }
    }

}

<?php

namespace Symfony\Base\Shared\Domain;

abstract class ValueObject
{
    public function equals(self $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->value() === $other->value();
    }

    abstract protected function value(): mixed;
}

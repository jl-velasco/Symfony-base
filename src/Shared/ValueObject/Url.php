<?php

namespace Symfony\Base\Shared\ValueObject;

class Url extends StringValueObject
{

    public function __construct(protected string $value)
    {
        parent::__construct($this->value());
       // $this->validate();
    }
    public function isEquals(Url $other): bool
    {
        return $this->value === $other->value;
    }
    private function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
//            throw new InvalidValueException($this->value);
        }
    }
}

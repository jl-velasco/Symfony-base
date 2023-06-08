<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\StringValueObject;

class VideoUrl extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
//            throw new InvalidValueException($this->value);
        }
    }

}
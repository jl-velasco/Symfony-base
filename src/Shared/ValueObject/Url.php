<?php

namespace Symfony\Base\Shared\ValueObject;

class Url extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    private function validate(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL provided.');
        }
    }
}

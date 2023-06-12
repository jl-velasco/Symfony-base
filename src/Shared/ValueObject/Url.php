<?php

namespace Symfony\Base\Shared\ValueObject;

class Url extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->validateUrl($value);
        parent::__construct($value);
    }

    private function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL provided.');
        }
    }
}

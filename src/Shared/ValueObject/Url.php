<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

class Url extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (strlen($this->value) > 254) {
            throw new InvalidValueException($this->value);
        }
    }
}

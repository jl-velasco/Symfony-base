<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;

class Url extends StringValueObject
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
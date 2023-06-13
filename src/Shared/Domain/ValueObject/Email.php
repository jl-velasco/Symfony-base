<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\ValueObject;

final class Email extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($this->value);
//        $this->validate();
    }

    public function isEquals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    private function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid EMAIL provided.');
        }
    }
}

<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    /** @throws InvalidValueException */
    public function __construct(protected string $value)
    {
        $this->validate();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public static function isValid(string $id): bool
    {
        return RamseyUuid::isValid($id);
    }

    /** @throws InvalidValueException */
    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function value(): string
    {
        return strtolower($this->value);
    }

    public function equals(Uuid $other): bool
    {
        return strtolower($this->value()) === strtolower($other->value());
    }

    /** @throws InvalidValueException */
    private function validate(): void
    {
        if (!self::isValid($this->value)) {
            throw new InvalidValueException(
                self::class,
                $this->value,
                'The value is not a valid UUID'
            );
        }
    }
}

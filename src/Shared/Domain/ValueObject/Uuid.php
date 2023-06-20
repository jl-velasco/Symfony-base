<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;

class Uuid
{
    /** @throws InvalidValueException */
    public function __construct(protected string $value)
    {
        if (!Uuid::isValid($this->value))
            throw new InvalidValueException("Not acceptable UUID format");
        $this->validate($value);
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
        return $this->value;
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    /** @throws InvalidValueException */
    private function validate(string $id): void
    {
        if (!self::isValid($id)) {
            throw new InvalidValueException("Not acceptable UUID format");
        }
    }
}

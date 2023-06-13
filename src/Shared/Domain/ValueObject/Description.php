<?php

namespace Symfony\Base\Shared\Domain\ValueObject;


use Symfony\Base\Shared\Domain\Exception\InvalidValueException;

class Description extends StringValueObject
{
    public const MAX_LENGTH = 1000;

    /**
     * @throws InvalidValueException
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    /**
     * @throws InvalidValueException
     */
    private function validate(string $value): void
    {
        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidValueException(
                sprintf(
                    'Description must be less than %s characters',
                    self::MAX_LENGTH
                )
            );
        }
    }
}
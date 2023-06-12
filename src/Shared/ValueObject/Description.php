<?php

namespace Symfony\Base\Shared\ValueObject;

use Symfony\Base\Shared\Exception\InvalidValueException;

class Description extends StringValueObject
{
    const MAX_LENGTH = 1000;

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
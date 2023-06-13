<?php

namespace Symfony\Base\Video\Domain;


use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;

class Message extends StringValueObject
{
    public const MAX_LENGTH = 5000;

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
                    'Message must be less than %s characters',
                    self::MAX_LENGTH
                )
            );
        }
    }
}
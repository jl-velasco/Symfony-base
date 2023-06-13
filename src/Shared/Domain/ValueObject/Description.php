<?php

declare(strict_types=1);
namespace Symfony\Base\Shared\ValueObject;

use Symfony\Base\Shared\Exception\InvalidValueException;

class Description extends StringValueObject
{

    public function __construct(protected string $value)
    {
        parent::__construct($this->value);
       // $this->validate();
    }

    private function validate(): void
    {
        if (!empty($this->value) >1000) {
         throw new InvalidValueException("La descripcion no puede excederse de los 1000 caracteres");
        }
    }
}


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


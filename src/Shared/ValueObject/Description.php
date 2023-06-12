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

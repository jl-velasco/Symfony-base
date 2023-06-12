<?php
declare(strict_types=1);
namespace Symfony\Base\Shared\ValueObject;

class Description extends StringValueObject
{

    public function __construct(protected string $value)
    {
        parent::__construct($this->value);
       // $this->validate();
    }

    private function validate(): void
    {
        if (!empty($this->value)) {
//            throw new InvalidValueException($this->value);
        }
    }
}

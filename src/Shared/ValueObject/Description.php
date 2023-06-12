<?php
declare(strict_types=1);


namespace Symfony\Base\Shared\ValueObject;

class Description extends StringValueObject
{
    const LEN_DESCRIPTION = '1000';

    public function __construct(protected string $value)
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (strlen($this->value)>= self::LEN_DESCRIPTION) {
//            throw new InvalidValueException($this->value);
        }
    }
}
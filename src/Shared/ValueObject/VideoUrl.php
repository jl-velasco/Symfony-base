<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

class VideoUrl extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            //@todo exception
//            throw new InvalidValueException($this->value);
        }
    }
}
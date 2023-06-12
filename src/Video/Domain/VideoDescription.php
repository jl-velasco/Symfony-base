<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\ValueObject;

class VideoDescription extends StringValueObject
{

    private const DEF_MAX_LENGTH = 1000;

    public function __construct(protected string $value = '')
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (mb_strlen($this->value) > self::DEF_MAX_LENGTH) {
            //@todo exception
//            throw new InvalidValueException($this->value);
        }
    }
}
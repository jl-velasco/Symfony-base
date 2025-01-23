<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\StringValueObject;

class VideoDescription extends StringValueObject
{
    //validate
    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->validate();
    }

    public function validate()
    {
        if (strlen($this->value) > 500) {
            throw new \InvalidArgumentException('The description is too long');
        }
    }

}
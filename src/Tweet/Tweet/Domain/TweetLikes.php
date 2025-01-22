<?php

namespace Symfony\Base\Tweet\Tweet\Domain;

use Symfony\Base\Shared\Domain\IntValueObject;

class TweetLikes extends IntValueObject
{
    public static function create(): self
    {
        return new self(0);
    }

    public function addLike(): self
    {
        return new self($this->value() + 1);
    }
}
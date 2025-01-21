<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\IntValueObject;

class VideoLikes extends IntValueObject
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
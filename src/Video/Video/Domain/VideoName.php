<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\StringValueObject;

class VideoName extends StringValueObject
{
    public function update(string $name): self
    {
        return new self($name);
    }
}
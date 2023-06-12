<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Serializable;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class User implements Serializable
{
    public function __construct(private readonly Uuid $id)
    {
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function serialize(): mixed
    {
        return (string) $this;
    }

    public function id(): Uuid
    {
        return $this->id;
    }
}

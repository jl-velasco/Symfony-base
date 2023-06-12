<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

interface Serializable
{
    public function serialize(): mixed;
}

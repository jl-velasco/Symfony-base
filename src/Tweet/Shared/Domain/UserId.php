<?php

namespace Symfony\Base\Tweet\Shared\Domain;

use Symfony\Base\Shared\Domain\Uuid;

class UserId extends Uuid
{

    public function update(UserId $userId)
    {
        return new self($userId->value());
    }
}
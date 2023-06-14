<?php

declare(strict_types=1);

namespace Symfony\Base\User\Application;

use Symfony\Base\User\Domain\User;

final class UserResponse
{
    public function __construct(
        private readonly User $user,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->user->id()->value(),
            'email' => $this->user->email()->value(),
            'name' => $this->user->name()->value(),
        ];
    }
}

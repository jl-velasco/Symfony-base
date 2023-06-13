<?php

declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

final class UserResponse
{
    public function __construct(
        private readonly array $data,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->data['id'],
            'email' => $this->data['email'],
            'name' => $this->data['name'],
        ];
    }
}

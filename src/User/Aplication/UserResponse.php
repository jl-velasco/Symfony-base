<?php

declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

final class UserResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $name,
        private readonly int $videoCounter
    )
    {
    }

    /** @return array<string, int|string> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'video_counter' => $this->videoCounter
        ];
    }
}

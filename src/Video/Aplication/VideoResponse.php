<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

final class VideoResponse
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $userUuid,
        private readonly string $name,
        private readonly string $description,
        private readonly string $url
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'email' => $this->userUuid,
            'name' => $this->name,
            'name' => $this->description,
            'name' => $this->url
        ];
    }
}

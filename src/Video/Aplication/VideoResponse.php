<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

final class VideoResponse
{
    public function __construct(
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
            'user_id' => $this->userUuid,
            'name' => $this->name,
            'description' => $this->description
            'url' => $this->url
        ];
    }
}

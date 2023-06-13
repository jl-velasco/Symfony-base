<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

final class VideoResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $userId,
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
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url
        ];
    }
}

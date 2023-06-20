<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Application;

final class VideoResponse
{
    public function __construct(
        private readonly string  $uuid,
        private readonly string  $userUuid,
        private readonly string  $name,
        private readonly string  $description,
        private readonly string  $url,
        private readonly ?string $createdAt = null,
        private readonly ?string $updatedAt = null
    )
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'user_id' => $this->userUuid,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}

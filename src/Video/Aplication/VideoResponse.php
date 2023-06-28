<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

final class VideoResponse implements Response
{
    public function __construct(
        private readonly string  $uuid,
        private readonly string  $userUuid,
        private readonly string  $name
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
            'name' => $this->name
            ];
    }
}
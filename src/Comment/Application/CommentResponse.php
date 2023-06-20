<?php

declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

final class CommentResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $videoId,
        private readonly string $message,
        private readonly string $created_at,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'video_id' => $this->videoId,
            'message' => $this->message,
            'createdAt' => $this->created_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

final class CommentResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $videoId,
        private readonly string $message,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'video_id' => $this->videoId,
            'message' => $this->message
        ];
    }
}

<?php

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Response;

class CommentResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $videoId,
        private readonly string $message,
        private readonly string $userId
    )
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->id,
            'video_id' => $this->videoId,
            'name' => $this->message,
            'user_id' => $this->userId
        ];
    }
}
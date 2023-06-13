<?php

declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

final class CommentResponse
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
            'video_id' => $this->data['video_id'],
            'message' => $this->data['comment'],
            'createdAt' => $this->data['created_at'],
        ];
    }
}

<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Query\Response;

class VideoResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $userId,
        private readonly string $name,
        private readonly string $description,
        private readonly string $url,
        private readonly int $likes,
    )
    {
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'likes' => $this->likes,
        ];
    }
}
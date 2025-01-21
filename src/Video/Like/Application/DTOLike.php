<?php

namespace Symfony\Base\Video\Like\Application;

class DTOLike
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $videoId,
    )
    {
    }
}
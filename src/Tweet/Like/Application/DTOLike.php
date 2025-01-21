<?php

namespace Symfony\Base\Tweet\Like\Application;

class DTOLike
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $tweetId,
    )
    {
    }
}
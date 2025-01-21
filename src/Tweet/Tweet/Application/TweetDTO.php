<?php

namespace Symfony\Base\Tweet\Tweet\Application;

use Symfony\Base\Tweet\Shared\Domain\Content;
use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Shared\Domain\UserId;

class TweetDTO
{
    public function __construct(
        public readonly TweetId $id,
        public readonly UserId $userId,
        public readonly Content $content
    )
    {
    }

}
<?php

namespace Symfony\Base\Tweet\Tweet\Domain;

use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Shared\Domain\UserId;

interface TweetRepository
{
    public function save(Tweet $tweet): void;

    public function search(TweetId $id): ?Tweet;

    public function delete(TweetId $id): void;
}
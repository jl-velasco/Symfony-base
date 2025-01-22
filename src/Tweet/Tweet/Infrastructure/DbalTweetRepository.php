<?php

namespace Symfony\Base\Tweet\Tweet\Infrastructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Tweet\Domain\Tweet;
use Symfony\Base\Tweet\Tweet\Domain\TweetRepository;

class DbalTweetRepository implements TweetRepository
{
    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function save (Tweet $tweet): void
    {
        //if exists update else insert
        $this->connection->insert('tweets', [
            'id' => $tweet->id()->value(),
            'user_id' => $tweet->userId()->value(),
            'content' => $tweet->content()->value(),
            'created_at' => $tweet->createdAt()->value(),
            'updated_at' => $tweet->updatedAt()->value(),
        ]);
    }
    public function search(TweetId $id): ?Tweet
    {

    }
    public function delete(TweetId $id): void
    {
        // TODO: Implement delete() method.
    }
}
<?php

namespace Symfony\Base\Tweet\Tweet\Domain;

use Symfony\Base\Tweet\Shared\Domain\TweetId;

class TweetFinder
{
    private TweetRepository $repository;

    public function __construct(TweetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(TweetId $id): Tweet
    {
        $tweet = $this->repository->search($id);

        if (null === $tweet) {
            throw new TweetNotFoundException($id);
        }

        return $tweet;
    }
}
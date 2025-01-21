<?php

namespace Symfony\Base\Tweet\Tweet\Domain;

class TweetFinder
{
    private $repository;

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
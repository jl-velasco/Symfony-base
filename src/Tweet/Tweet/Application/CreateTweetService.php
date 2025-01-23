<?php

namespace Symfony\Base\Tweet\Tweet\Application;

use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Tweet\Domain\Tweet;
use Symfony\Base\Tweet\Tweet\Domain\TweetAlreadyExistsException;
use Symfony\Base\Tweet\Tweet\Domain\TweetFinder;
use Symfony\Base\Tweet\Tweet\Domain\TweetNotFoundException;
use Symfony\Base\Tweet\Tweet\Domain\TweetRepository;

class CreateTweetService
{
    public function __construct(
        private TweetRepository $repository,
        private TweetFinder $finder
        )
    {
    }

    public function __invoke(TweetDTO $tweet): void
    {
        try {
            $this->ensureIfTweetExists($tweet->id);
        } catch (TweetNotFoundException $e) {
            $tweet = Tweet::create($tweet->id, $tweet->userId, $tweet->content);
            $tweet->save($this->repository);
        }


    }

    public function ensureIfTweetExists(TweetId $id)
    {
        $this->finder->findById($id);

        throw new TweetAlreadyExistsException();
    }
}
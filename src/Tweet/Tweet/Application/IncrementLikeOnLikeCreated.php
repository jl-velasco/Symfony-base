<?php

namespace Symfony\Base\Tweet\Tweet\Application;

use Symfony\Base\Shared\Domain\DomainEvent;
use Symfony\Base\Shared\Domain\DomainEventSubscriber;
use Symfony\Base\Tweet\Like\Domain\LikeCreated;
use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Tweet\Domain\TweetFinder;
use Symfony\Base\Tweet\Tweet\Domain\TweetRepository;

class IncrementLikeOnLikeCreated implements DomainEventSubscriber
{
    public function __construct(
        private TweetFinder $finder,
        private TweetRepository $repository
    )
    {
    }


    public static function subscribedTo(): array
    {
        return [LikeCreated::class];
    }

    public function __invoke(DomainEvent $event): void
    {
        if (!$event instanceof LikeCreated) {
            throw new \InvalidArgumentException('Event must be an instance of LikeCreated');
        }

        $toPrimitives = $event->toPrimitives();
        $id = new TweetId($toPrimitives['tweet_id']);
        $tweet = $this->finder->findById($id);
        $tweet->addLike();
        $tweet->save($this->repository);
    }
}
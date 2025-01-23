<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\DomainEvent;
use Symfony\Base\Shared\Domain\DomainEventSubscriber;
use Symfony\Base\Video\Shared\Domain\LikeCreated;
use Symfony\Base\Video\Shared\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\VideoFinder;
use Symfony\Base\Video\Video\Domain\VideoRepository;

class IncrementLikeOnLikeCreated implements DomainEventSubscriber
{
    public function __construct(
        private VideoFinder $finder,
        private VideoRepository $repository
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
        $id = new VideoId($toPrimitives['video_id']);
        $video = $this->finder->findById($id);
        $video->addLike();
        $video->save($this->repository);
    }
}
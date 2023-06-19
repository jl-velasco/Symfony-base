<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;
use Symfony\Base\Video\Domain\VideoCreated;

class VideoCreatedAddVideoCounterConsumer implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'video.video_created.add_video_counter';

    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $user = $this->finder->__invoke(new Uuid($data['user_id']));
        $user->addVideo();
        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [VideoCreated::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}
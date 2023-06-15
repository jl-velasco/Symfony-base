<?php

declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoAddedOrDeletedConsumer implements DomainEventSubscriber
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $user = $this->repository->search(new Uuid($data['user_id']));
        if (!$user) {
            return;
        }

        $stats = $this->repository->findUserStats($user);
        match(get_class($event)) {
            VideoAdded::class => $stats->increaseVideosCount(),
            VideoDeleted::class => $stats->decreaseVideosCount(),
        };

        $this->repository->save($user->withStats($stats));
    }

    /**
     * @inheritDoc
     */
    public static function subscribedTo(): array
    {
        return [VideoAdded::class, VideoDeleted::class];
    }
}
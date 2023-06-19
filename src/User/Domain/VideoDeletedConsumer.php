<?php

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoDeleted;

abstract class VideoDeletedConsumer implements DomainEventSubscriber
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
public static function videoDeletedTo():array{
    return [VideoDeleted::class];
}

}

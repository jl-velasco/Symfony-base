<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoDeleted;

class VideoDeletedConsumer// implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $user = $this->finder->__invoke(new Uuid($data['user_id']));
        $user->substractVideo();
        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [VideoDeleted::class];
    }
}
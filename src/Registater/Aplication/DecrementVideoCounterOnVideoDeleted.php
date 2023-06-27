<?php
declare(strict_types = 1);

namespace Symfony\Base\Registater\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Registater\Domain\Exceptions\UserNotExistException;
use Symfony\Base\Registater\Domain\UserFinder;
use Symfony\Base\Registater\Domain\UserRepository;
use Symfony\Base\Video\Domain\VideoDeletedDomainEvent;

class DecrementVideoCounterOnVideoDeleted implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder
    )
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $user = $this->finder->__invoke(new Uuid($data['user_id']));
        $user->decreaseVideoCounter();
        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [VideoDeletedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return 'video.video_deleted.decrease_video_counter';
    }
}
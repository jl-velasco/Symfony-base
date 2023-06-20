<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;

class IncrementVideoCounterOnVideoCreated implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder
    ) {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $user = $this->finder->__invoke(new Uuid($data['user_id']));
        $user->increaseVideoCounter();

        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [VideoCreatedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return 'video.video_created.increase_video_counter';
    }
}
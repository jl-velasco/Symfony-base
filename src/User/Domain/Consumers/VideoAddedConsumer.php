<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain\Consumers;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserRepository;
use Symfony\Base\Video\Domain\Events\VideoAddedEvent;

class VideoAddedConsumer implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'video.video_added.increment';

    public function __construct(
        private readonly UserRepository $repository,
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(DomainEvent $event): void
    {
        $this->repository->incrementVideo($event->userId());
    }

    public static function subscribedTo(): array
    {
        return [VideoAddedEvent::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}

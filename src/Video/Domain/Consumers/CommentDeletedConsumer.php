<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain\Consumers;

use Symfony\Base\Comment\Domain\Events\CommentDeletedEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Video\Domain\VideoRepository;

class CommentDeletedConsumer implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'comment.comment_deleted.decrement';

    public function __construct(
        private readonly VideoRepository $repository,
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(DomainEvent $event): void
    {
        $this->repository->decrementComment($event->videoId());
    }

    public static function subscribedTo(): array
    {
        return [CommentDeletedEvent::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}

<?php

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentMessage;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\CommentCreatedDomainEvent;

class CreateCommentOnCommentCreated implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'comment.comments_created.create_comments';

    public function __construct(
        private readonly CommentRepository $repository
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $comment = new Comment(
            new Uuid($data['comment_id']),
            new Uuid($event->aggregateId()),
            new CommentMessage($data['message']),
            new Uuid($data['user_id'])
        );

        $this->repository->save($comment);
    }

    public static function subscribedTo(): array
    {
        return [CommentCreatedDomainEvent::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}
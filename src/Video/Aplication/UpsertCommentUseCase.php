<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentRepository;
use Symfony\Base\Video\Domain\Message;

class UpsertCommentUseCase
{
    public function __construct(
        private readonly CommentRepository $repository
    )
    {
    }

    public function __invoke(
        string $id,
        string $videoId,
        string $message,
    ): void
    {
        $this->repository->save(
            new Comment(
                new Uuid($id),
                new Uuid($videoId),
                new Message($message),
            )
        );
    }


}
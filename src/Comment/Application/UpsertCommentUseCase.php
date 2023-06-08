<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;

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
        string $comment,
        string $createdAt,
        string $updatedAt,
    ): void
    {
        $this->repository->save(
            new Comment(
                new Uuid($id),
                new Uuid($videoId),
                new Description($comment),
                new CreatedAt(new \DateTime($createdAt)),
                new UpdatedAt(new \DateTime($updatedAt)),
            )
        );
    }


}

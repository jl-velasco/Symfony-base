<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Application;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comments\Dominio\Comment;
use Symfony\Base\Comments\Dominio\Comments;
use Symfony\Base\Comments\Dominio\CommentsRepositoryInterface;

class UpsertCommentsUseCase
{
    public function __construct(private readonly CommentsRepositoryInterface $repository)
    {
    }

    public function __invoke(
        string $id,
        string $videoId,
        string $comment,
        string $updatedAt,
        string $createdAt,
    ): void
    {
        $this->repository->save(
            new Comments(
                new Uuid($id),
                new Uuid($videoId),
                new Comment($comment),
                new UpdatedAt($updatedAt),
                new CreatedAt($createdAt)
            )
        );
    }


}

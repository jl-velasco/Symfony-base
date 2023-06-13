<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
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

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id,
        string $videoId,
        string $comment,
        string $createdAt = '',
        string $updatedAt = '',
    ): array
    {
        return $this->repository->save(
            new Comment(
                new Uuid($id),
                new Uuid($videoId),
                new Description($comment),
                CreatedAt::fromPrimitive($createdAt),
                UpdatedAt::fromPrimitive($updatedAt),
            )
        )->toPrimitives();
    }


}

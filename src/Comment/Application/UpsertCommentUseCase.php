<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\CreatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class UpsertCommentUseCase
{
    public function __construct(
        private readonly CommentRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     * @throws \Symfony\Base\Shared\Domain\Exception\InvalidValueException
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

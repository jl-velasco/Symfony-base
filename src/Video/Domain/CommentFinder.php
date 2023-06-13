<?php

declare(strict_types = 1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\CommentNotExistException;

final class CommentFinder
{
    public function __construct(private readonly CommentRepository $repository)
    {
    }

    /**
     * @throws CommentNotExistException
     */
    public function __invoke(Uuid $id): Comment
    {
        $comment = $this->repository->findById($id);

        if ($comment === null) {
            throw new CommentNotExistException((string) $id);
        }

        return $comment;
    }
}

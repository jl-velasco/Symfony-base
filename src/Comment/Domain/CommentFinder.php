<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\CommentNotFoundException;

class CommentFinder
{
    public function __construct(private readonly CommentRepository $repository)
    {
    }

    /**
     * @throws CommentNotFoundException
     */
    public function __invoke(Uuid $id): Comment
    {
        $comment = $this->repository->find($id);
        if ($comment === null) {
            throw new CommentNotFoundException((string) $id);
        }

        return $comment;
    }
}
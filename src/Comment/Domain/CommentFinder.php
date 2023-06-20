<?php

declare(strict_types = 1);

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Comment\Domain\Exceptions\CommentNotFoundException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;


final class CommentFinder
{
    public function __construct(private readonly CommentRepository $repository)
    {
    }

    public function __invoke(Uuid $id): Comment
    {
        $comment = $this->repository->search($id);

        if ($comment === null) {
            throw new CommentNotFoundException((string) $id);
        }

        return $comment;
    }
}

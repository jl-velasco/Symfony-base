<?php

namespace Symfony\Base\Shared\Comment\Aplication;

use Symfony\Base\Shared\Comment\Domain\CommentRespository;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Comment;

class CommentFinder
{
public function __construct(private readonly CommentRespository $commentRespository)
{
}

public function __invoke(Uuid $comment_id): Comment
{
    $comment = $this->commentRespository->search($comment_id);
    if ($comment === null) {
    throw new CommentNotExistException((string)$comment_id);
    }
    return $comment;
}
}

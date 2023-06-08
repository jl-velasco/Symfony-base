<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;

class MySQLCommentRepository implements CommentRepository
{
    public function save(Comment $comment): void
    {

    }

    public function search(Uuid $id): Comment
    {

    }

    public function delete(Uuid $id): void
    {
        // TODO: Implement delete() method.
    }
}

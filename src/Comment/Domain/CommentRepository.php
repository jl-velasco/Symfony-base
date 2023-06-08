<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\ValueObject\Uuid;

interface CommentRepository
{
    public function save(Comment $user): void;

    public function search(Uuid $id): Comment;

    public function delete(Uuid $id): void;
}

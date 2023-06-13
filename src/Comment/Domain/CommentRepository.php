<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface CommentRepository
{
    public function save(Comment $comment): Comment;

    public function search(Uuid $id): Comment|null;

    public function getByVideo(Uuid $id): CommentCollection;

    public function delete(Uuid $id): void;

}

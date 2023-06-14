<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface CommentRepository
{
    public function save(Comment $Comment): void;

    public function find(Uuid $uuid): ?Comment;

    public function delete(Uuid $uuid): void;
}
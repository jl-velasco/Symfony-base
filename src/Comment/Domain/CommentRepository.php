<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface CommentRepository
{
    public function save(Comment $comment): void;

    public function find(Uuid $id): ?Comment;

    public function findByVideoId(Uuid $videoId): Comments;

    public function findByUserId(Uuid $userId): Comments;

    public function delete(Uuid $id): void;

    public function deleteByVideoId(Uuid $videoId): void;

    public function deleteByUserId(Uuid $userId): void;
}
<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface CommentRepository
{
    public function save(Comment $comment): int;

    public function findById(Uuid $id): ?Comment;

    public function findByVideoId(Uuid $videoId): array;

    public function deleteById(Uuid $id): int;
}
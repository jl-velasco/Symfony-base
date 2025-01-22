<?php

namespace Symfony\Base\Video\Like\Infrastructure;

use Symfony\Base\Video\Like\Domain\Like;
use Symfony\Base\Video\Like\Domain\LikeId;
use Symfony\Base\Video\Like\Domain\LikeRepository;

class DbalLikeRepository implements LikeRepository
{

    public function save(Like $like): void
    {
        // TODO: Implement save() method.
    }

    public function find(LikeId $id): ?Like
    {
        return null;
    }

    public function delete(LikeId $id): void
    {
        // TODO: Implement delete() method.
    }
}
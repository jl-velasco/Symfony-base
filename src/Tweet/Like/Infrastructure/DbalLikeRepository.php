<?php

namespace Symfony\Base\Tweet\Like\Infrastructure;


use Symfony\Base\Tweet\Like\Domain\Like;
use Symfony\Base\Tweet\Like\Domain\LikeId;
use Symfony\Base\Tweet\Like\Domain\LikeRepository;

class DbalLikeRepository implements LikeRepository
{

    public function save(Like $like): void
    {
        // TODO: Implement save() method.
    }

    public function find(LikeId $id): ?Like
    {
        // TODO: Implement find() method.
    }

    public function delete(LikeId $id): void
    {
        // TODO: Implement delete() method.
    }
}
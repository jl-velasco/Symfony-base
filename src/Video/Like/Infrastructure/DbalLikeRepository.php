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
        return new Like(
            new LikeId('1'),
            new VideoId('1'),
            new LikeUserId('1'),
            new CreatedAt()
        );
    }

    public function delete(LikeId $id): void
    {
        // TODO: Implement delete() method.
    }
}
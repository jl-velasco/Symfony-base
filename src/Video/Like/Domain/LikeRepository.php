<?php

namespace Symfony\Base\Video\Like\Domain;

interface LikeRepository
{
    public function save(Like $like): void;

    public function find(LikeId $id): ?Like;

    public function delete(LikeId $id): void;
}
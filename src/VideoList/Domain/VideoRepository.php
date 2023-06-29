<?php

namespace Symfony\Base\VideoList\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video): void;

    public function find(Uuid $id): ?Video;

    public function findByUserId(Uuid $userId): Videos;

    public function delete(Uuid $id): void;
}
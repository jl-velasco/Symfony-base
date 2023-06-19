<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video): void;

    public function find(Uuid $uuid): ?Video;

    public function findByUserId(Uuid $userId): Videos;

    public function delete(Uuid $uuid): void;
}
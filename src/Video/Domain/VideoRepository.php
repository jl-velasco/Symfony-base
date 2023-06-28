<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\User;

interface VideoRepository
{
    public function save(Video $video): void;

    public function search(Uuid $id): ?Video;

    //public function find(Uuid $uuid): ?Video;

    //public function findByUserId(Uuid $userId): Videos;

    public function delete(Uuid $uuid): void;
}
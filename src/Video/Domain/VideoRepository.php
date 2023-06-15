<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;


interface VideoRepository
{
    public function save(Video $video): void;

    public function find(Uuid $videoId): ?Video;

    public function findByUserUuid(Uuid $videoId): array;

    public function delete(Uuid $videoId): void;

    public function deleteByUserId(Uuid $videoId): void;

}

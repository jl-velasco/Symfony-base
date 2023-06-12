<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video): void;

    public function findByUuid(Uuid $uuid): ?Video;

    public function findByUserUuid(Uuid $userUuid): array;

    public function deleteByUuid(Uuid $uuid): void;
}
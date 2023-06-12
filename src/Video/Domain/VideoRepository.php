<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video): void;

    public function delete(Video $video): void;

    public function findById(Uuid $id): Video;

    public function findAll(): VideoCollection;
}

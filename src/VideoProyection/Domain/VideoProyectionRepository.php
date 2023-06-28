<?php

namespace Symfony\Base\VideoProyection\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;

interface VideoProyectionRepository
{
    public function save(Video $video): void;

    public function search(Uuid $id): ?Video;

    public function delete(Uuid $id): void;

}
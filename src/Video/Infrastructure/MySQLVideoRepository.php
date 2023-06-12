<?php

namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class MySQLVideoRepository implements VideoRepository
{

    public function save(Video $video): void
    {
        // TODO: Implement save() method.
    }

    public function search(Uuid $id): Video
    {
        // TODO: Implement search() method.
    }

    public function delete(Uuid $id): void
    {
        // TODO: Implement delete() method.
    }
}
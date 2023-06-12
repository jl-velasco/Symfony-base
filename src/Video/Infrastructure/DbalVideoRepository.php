<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\DbalRepository;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoCollection;
use Symfony\Base\Video\Domain\VideoRepository;

class DbalVideoRepository extends DbalRepository implements VideoRepository
{
    public function save(Video $video): void
    {
        // TODO: Implement save() method.
    }

    public function delete(Video $video): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(Uuid $id): Video
    {
        // TODO: Implement findById() method.
    }

    public function findAll(): VideoCollection
    {
        // TODO: Implement findAll() method.
    }
}

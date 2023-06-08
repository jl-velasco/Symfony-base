<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Dominio\Video;
use Symfony\Base\Video\Dominio\VideoRepository;


class MySQLVideoRepository implements VideoRepository
{
    public function save(Video $video): void
    {

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

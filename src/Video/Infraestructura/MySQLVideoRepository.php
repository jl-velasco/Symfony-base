<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Infraestructura;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Dominio\User;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;
use Doctrine\DBAL\Connection;

class MySQLVideoRepository implements VideoRepository
{

    public function save(Video $video): void
    {
        if ($this->search($video->video())) {
            $this->update($video);
        } else {
            $this->insert($video);
        }
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

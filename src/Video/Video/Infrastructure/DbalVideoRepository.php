<?php

namespace Symfony\Base\Video\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Video\Shared\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\Video;
use Symfony\Base\Video\Video\Domain\VideoRepository;

class DbalVideoRepository implements VideoRepository
{
    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function save(Video $video): void
    {
        if ($this->exists($video->id())) {
            $this->update($video);
            return;
        }

        $this->insert($video);
    }

    private function exists(VideoId $id): bool
    {
        $data = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('video')
            ->where('id = :id')
            ->setParameter('id', $id->value())
            ->execute()
            ->fetchOne();

        return $data > 0;
    }

    public function search(VideoId $id): ?Video
    {
        $data = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('video')
            ->where('id = :id')
            ->setParameter('id', $id->value())
            ->execute()
            ->fetchOne();

        if ($data === false) {
            return null;
        }

        return Video::fromPrimitives(
            $data
        );
    }

    public function delete(VideoId $id): void
    {
        $this->connection->createQueryBuilder()
            ->delete('video')
            ->where('id = :id')
            ->setParameter('id', $id->value())
            ->execute();
    }

    private function insert(Video $video)
    {
        $this->connection->createQueryBuilder()
            ->insert('video')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'description' => ':description',
                'url' => ':url',
            ])
            ->setParameters([
                'id' => $video->id()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
            ])
            ->execute();
    }

    private function update(Video $video)
    {
        $this->connection->createQueryBuilder()
            ->update('video')
            ->set('name', ':name')
            ->set('description', ':description')
            ->set('url', ':url')
            ->where('id = :id')
            ->setParameters([
                'id' => $video->id()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
            ])
            ->execute();
    }
}
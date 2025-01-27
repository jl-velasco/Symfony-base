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
            ->executeQuery()
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
            ->executeQuery()
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
            ->executeQuery();
    }

    private function insert(Video $video)
    {
        $this->connection->createQueryBuilder()
            ->insert('video')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'user_id' => ':user_id',
                'description' => ':description',
                'url' => ':url',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'id' => $video->id()->value(),
                'name' => $video->name()->value(),
                'user_id' => $video->userId()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
                'created_at' => $video->createdAt()->stringDateTime(),
            ])
            ->executeQuery();
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
            ->executeQuery();
    }
}
<?php

namespace Symfony\Base\Video\Infraestructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class MySqlVideoRepository implements VideoRepository
{


    const TABLE_VIDEO = 'video';

    public function __construct(private Connection $connection)
    {
    }

    public function save(Video $video): void
    {
        $uuid = $video->uuid();
        $userUuid = $video->userUuid();
        $name = $video->name();
        $description = $video->description();
        $url = $video->url();
        $createdAt = $video->createdAt();
        $updatedAt = $video->updatedAt();

        try {
            $this->connection->insert(
                self::TABLE_VIDEO,
                [
                    'id' => $uuid->value(),
                    'user_id' => $userUuid->value(),
                    'name' => $name->value(),
                    'description' => $description->value(),
                    'url' => $url->value(),
                    'created_at' => $createdAt->stringDateTime()
                ]
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function findByUuid(Uuid $uuid): ?Video
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from(self::TABLE_VIDEO)
            ->where('id = :id')
            ->setParameter('id', $uuid->value());

        $statement = $queryBuilder->execute();

        $result = $statement->fetchAssociative();

        if (!$result) {
            return null;
        }

        return new Video(
            new Uuid($result['id']),
            new Uuid($result['user_id']),
            $result['name'],
            $result['description'],
            $result['url'],
            new \DateTime($result['created_at']),
            new \DateTime($result['updated_at'])
        );
    }

    public function findByUserUuid(Uuid $userUuid): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from(self::TABLE_VIDEO)
            ->where('user_id = :user_id')
            ->setParameter('user_id', $userUuid->value());

        $statement = $queryBuilder->execute();

        $result = $statement->fetchAllAssociative();

        if (!$result) {
            return [];
        }

        $videos = [];

        foreach ($result as $video) {
            $videos[] = new Video(
                new Uuid($video['id']),
                new Uuid($video['user_id']),
                $video['name'],
                $video['description'],
                $video['url'],
                new \DateTime($video['created_at']),
                new \DateTime($video['updated_at'])
            );
        }

        return $videos;
    }

    public function deleteByUuid(Uuid $uuid): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->delete(self::TABLE_VIDEO)
            ->where('id = :id')
            ->setParameter('id', $uuid->value());

        $queryBuilder->execute();
    }
}
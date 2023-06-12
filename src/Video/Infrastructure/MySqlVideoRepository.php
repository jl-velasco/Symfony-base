<?php

namespace Symfony\Base\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Base\Shared\Exception\InvalidValueException;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Date;
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

        try {
            $this->connection->insert(
                self::TABLE_VIDEO,
                [
                    'id' => $video->uuid()->value(),
                    'user_id' => $video->userUuid()->value(),
                    'name' => $video->name()->value(),
                    'description' => $video->description()->value(),
                    'url' => $video->url()->value(),
                    'created_at' => $video->createdAt()->stringDateTime()
                ]
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
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
            new Name($result['name']),
            new Description($result['description']),
            new Url($result['url']),
            new Date($result['created_at']),
            new Date($result['updated_at'])
        );
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
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
                new Name($video['name']),
                new Description($video['description']),
                new Url($video['url']),
                new Date($video['created_at']),
                new Date($video['updated_at'])
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
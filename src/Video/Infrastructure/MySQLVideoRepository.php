<?php

namespace Symfony\Base\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class MySQLVideoRepository implements VideoRepository
{
    public const TABLE_VIDEO = 'video';

    public const TABLE_COMMENTS = 'comments';

    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws PersistenceLayerException|InvalidValueException|\Exception
     */
    public function save(Video $video): void
    {

        if (!$originalVideo = $this->find($video->uuid())) {
            $this->insert($video);
            return;
        }

        $this->update($video);
        $comments = $originalVideo->newComments($video);
        $this->connection->createQueryBuilder()
            ->insert(self::TABLE_COMMENTS)
            ->set('id', ':id')
            ->set('video_id', ':video')
            ->set('message', ':message')
            ->setParameters($comments->each(
                static function ($comment) {
                    return [
                        'id' => $comment->id(),
                        'video' => $comment->video(),
                        'message' => $comment->message(),
                    ];
                }
            ))
            ->executeQuery();
    }

    /**
     * @throws PersistenceLayerException|InvalidValueException
     */
    public function find(Uuid $uuid): ?Video
    {
        try {
            $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE_VIDEO)
                ->where('id = :id')
                ->setParameter('id', $uuid->value())
                ->executeQuery()
                ->fetchAssociative();
        }
        catch (Exception $e) {
            throw new PersistenceLayerException('Query error: ' .  $e->getMessage());
        }

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
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE_VIDEO)
            ->where('user_id = :user_id')
            ->setParameter('user_id', $userUuid->value())
            ->executeQuery()
            ->fetchAssociative();

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

    /**
     * @throws Exception
     */
    public function delete(Uuid $uuid): void
    {
        $this->connection->delete(
            self::TABLE_VIDEO,
            ['id' => $uuid->value()]
        );
    }

    /**
     * @throws PersistenceLayerException
     */
    public function insert(Video $video): void
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
                    'created_at' => $video->createdAt()?->stringDateTime()
                ]
            );
        }
        catch (Exception $e) {
            throw new PersistenceLayerException('Insert error: ' .  $e->getMessage());
        }
    }

    /**
     * @throws PersistenceLayerException
     */
    public function update(Video $video): void
    {
        try {
            $this->connection->createQueryBuilder()
                ->update(self::TABLE_VIDEO)
                ->set('name', ':name')
                ->set('description', ':description')
                ->set('url', ':url')
                ->set('updated_at', ':updated_at')
                ->where('id = :id')
                ->setParameters([
                    'id' => $video->uuid(),
                    'name' => $video->name(),
                    'description' => $video->description(),
                    'updated_at' => new Date(),
                ])
                ->executeQuery();
        }
        catch (Exception $e) {
            throw new PersistenceLayerException('Insert error: ' .  $e->getMessage());
        }
    }
}
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
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Domain\Comments;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;
use Symfony\Base\Video\Domain\Videos;

class MySQLVideoRepository implements VideoRepository
{
    private const TABLE_VIDEO = 'video';

    private const TABLE_COMMENT = 'comment';

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
        $comments->each(
            function ($comment) {
                $this->connection->createQueryBuilder()
                    ->insert(self::TABLE_COMMENT)
                    ->values(
                        [
                            'id' => ':id',
                            'video_id' => ':video_id',
                            'message' => ':message'
                        ]
                    )
                    ->setParameters([
                        'id' => $comment->id(),
                        'video_id' => $comment->videoId(),
                        'message' => $comment->message(),
                    ])
                    ->executeStatement();
            }
        );
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

            $comments = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE_COMMENT)
                ->where('video_id = :video_id')
                ->setParameter('video_id', $uuid->value())
                ->executeQuery()
                ->fetchAllAssociative();
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
            new Date($result['updated_at']),
            new Comments(
                array_map(
                    static function ($comment) {
                        return new Comment(
                            new Uuid($comment['id']),
                            new Uuid($comment['video_id']),
                            new CommentMessage($comment['message']),
                        );
                    },
                    $comments
                )
            )
        );
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function findByUserId(Uuid $userId): Videos
    {
        $videos = new Videos();
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE_VIDEO)
            ->where('user_id = :user_id')
            ->setParameter('user_id', $userId->value())
            ->executeQuery()
            ->fetchAllAssociative();

        if (!$result) {
            return $videos;
        }

        foreach ($result as $video) {
            $videos->add(
                new Video(
                    new Uuid($video['id']),
                    new Uuid($video['user_id']),
                    new Name($video['name']),
                    new Description($video['description']),
                    new Url($video['url']),
                    new Date($video['created_at']),
                    new Date($video['updated_at'])
                )
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
            self::TABLE_COMMENT,
            ['video_id' => $uuid->value()]
        );

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
                    'url' => $video->url(),
                    'updated_at' => new Date(),
                ])
                ->executeQuery();
        }
        catch (Exception $e) {
            throw new PersistenceLayerException('Insert error: ' .  $e->getMessage());
        }
    }
}
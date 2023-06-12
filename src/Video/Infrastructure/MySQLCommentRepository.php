<?php

namespace Symfony\Base\Comment\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Message;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentRepository;

class MySQLCommentRepository implements CommentRepository
{
    public const TABLE_COMMENT = 'comment';

    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(Comment $comment): int
    {
        if ($this->findById($comment->id())) {
            return $this->update($comment);
        } else {
            return $this->insert($comment);
        }
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function findById(Uuid $id): ?Comment
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE_COMMENT)
            ->where('id = :id')
            ->setParameter('id', $id->value())
            ->executeQuery()
            ->fetchAssociative();

        if (!$result) {
            return null;
        }

        return new Comment(
            new Uuid($result['id']),
            new Uuid($result['video_id']),
            new Message($result['name']),
            new Date($result['created_at']),
            new Date($result['updated_at'])
        );
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function findByVideoId(Uuid $videoId): array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE_COMMENT)
            ->where('video_id = :video_id')
            ->setParameter('video_id', $videoId->value())
            ->executeQuery()
            ->fetchAssociative();

        if (!$result) {
            return [];
        }

        $comments = [];
        foreach ($result as $comment) {
            $comments[] = new Comment(
                new Uuid($comment['id']),
                new Uuid($comment['user_id']),
                new Message($comment['name']),
                new Date($comment['created_at']),
                new Date($comment['updated_at'])
            );
        }

        return $comments;
    }

    public function deleteById(Uuid $id): int
    {
        return $this->connection->delete(
            self::TABLE_COMMENT,
            ['id' => $id->value()]
        );
    }

    /**
     * @throws Exception
     */
    private function insert(Comment $comment): int
    {
        return $this->connection->insert(
            self::TABLE_COMMENT,
            [
                'id' => $comment->id()->value(),
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value()
            ]
        );
    }

    /**
     * @throws Exception
     */
    private function update(Comment $comment): int
    {
        return $this->connection->createQueryBuilder()
            ->update(self::TABLE_COMMENT)
            ->set('video_id', ':video_id')
            ->set('name', ':name')
            ->set('message', ':message')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameters([
                'id' => $comment->id(),
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value(),
                'updated_at' => new Date(),
            ])
            ->executeQuery()
            ->rowCount();
    }
}
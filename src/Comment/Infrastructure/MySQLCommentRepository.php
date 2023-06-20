<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Infrastructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentCollection;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Comment\Domain\Exceptions\CommentNotFoundException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\SqlConnectionException;

class MySQLCommentRepository implements CommentRepository
{
    public const TABLE = 'comments';

    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function save(Comment $comment): Comment
    {
        try {
            if (!is_null($entity = $this->search($comment->id()))) {
                $this->connection->update(
                    self::TABLE,
                    $comment->toPrimitives(),
                    [
                        'id' => $entity->id()->value()
                    ]
                );
            } else
                $this->connection->insert(
                    self::TABLE,
                    $comment->toPrimitives(),
                );
        }
        catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }

        return $this->search($comment->id());
    }

    public function search(Uuid $id): Comment|null
    {
        try {
            $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE)
                ->where('id = :id')
                ->setParameter('id', $id->value())
                ->executeQuery()
                ->fetchAssociative();
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }

        if (!$result)
            return null;

        return Comment::fromPrimitives($result);
    }

    public function getByVideo(Uuid $id): CommentCollection
    {
        $result = new CommentCollection();

        try {
            $items = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE)
                ->where('video_id = :id')
                ->setParameter('id', $id->value())
                ->executeQuery()
                ->fetchAllAssociative();
            foreach ($items as $item)
                $result->add(Comment::fromPrimitives($item));
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }

        return $result;
    }

    public function delete(Uuid $id): void
    {
        if (is_null($this->search($id)))
            throw new CommentNotFoundException(sprintf('Comment not found. ID: %s',$id->value()));

        try {
            $this->connection->delete(
                self::TABLE,
                [
                    'id' => $id->value()
                ]
            );
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }
    }
}

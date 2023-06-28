<?php

namespace Symfony\Base\Comment\Infrastructure;

use Doctrine\DBAL\Exception;
use MongoDB\Collection;
use Symfony\Base\Comment\Domain\Comment;
use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Comment\Domain\Comments;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\Repository\Mongo;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Shared\Infrastructure\Mongo\MongoDBDocumentConverter;

class MongoDBCommentRepository implements CommentRepository
{
    private const COLLECTION = 'comment';
    private Collection $collection;

    public function __construct(
        private readonly Mongo $client,
    )
    {
        $this->collection = $this->client->collection(self::COLLECTION);
    }

    /**
     * @throws InvalidValueException
     * @throws PersistenceLayerException
     */
    public function find(Uuid $id): ?Comment
    {
        try {
            $comment = $this->collection->findOne([
                'id' => $id->value(),
            ]);

            if ($comment) {
                return Comment::fromArray(MongoDBDocumentConverter::toArray($comment));
            }

            return null;
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    /**
     * @throws PersistenceLayerException
     */
    public function save(Comment $comment): void
    {
        try {
            $this->collection->updateOne(
                ['id' => $comment->id()->value()],
                ['$set' => $comment->toArray()],
                ['upsert' => true]
            );
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    public function findByVideoId(Uuid $videoId): Comments
    {
        $findedComments = $this->collection->find([
            'video_id' => $videoId->value()
        ]);
        $comments = new Comments();
        foreach($findedComments as $comment) {
            $comments->add(new Comment(
                $comment['id'],
                $comment['video_id'],
                $comment['message'],
                $comment['user_id'],
            ));
        }

        return $comments;
    }

    public function findByUserId(Uuid $userId): Comments
    {
        $findedComments = $this->collection->find([
            'user_id' => $userId->value()
        ]);
        $comments = new Comments();
        foreach($findedComments as $comment) {
            $comments->add(new Comment(
                $comment['id'],
                $comment['video_id'],
                $comment['message'],
                $comment['user_id'],
            ));
        }

        return $comments;
    }

    /**
     * @throws PersistenceLayerException
     */
    public function delete(Uuid $id): void
    {
        try {
            $this->collection->deleteOne([
                'id' => $id->value(),
            ]);
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    public function deleteByVideoId(Uuid $videoId): void
    {
        try {
            $this->collection->deleteMany([
                'video_id' => $videoId->value(),
            ]);
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    public function deleteByUserId(Uuid $userId): void
    {
        try {
            $this->collection->deleteMany([
                'user_id' => $userId->value(),
            ]);
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }
}
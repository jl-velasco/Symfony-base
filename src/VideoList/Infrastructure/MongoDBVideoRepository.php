<?php

namespace Symfony\Base\VideoList\Infrastructure;

use Doctrine\DBAL\Exception;
use MongoDB\Collection;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Shared\Infrastructure\Mongo\MongoDBDocumentConverter;
use Symfony\Base\VideoList\Domain\Video;
use Symfony\Base\VideoList\Domain\VideoRepository;
use Symfony\Base\VideoList\Domain\Videos;

class MongoDBVideoRepository implements VideoRepository
{
    private const COLLECTION = 'video';
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
    public function find(Uuid $id): ?Video
    {
        try {
            $video = $this->collection->findOne([
                'id' => $id->value(),
            ]);

            if ($video) {
                return Video::fromArray(MongoDBDocumentConverter::toArray($video));
            }

            return null;
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    /**
     * @throws PersistenceLayerException
     */
    public function save(Video $video): void
    {
        try {
            $this->collection->updateOne(
                ['id' => $video->id()->value()],
                ['$set' => $video->toArray()],
                ['upsert' => true]
            );
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    public function findByUserId(Uuid $userId): Videos
    {
        //TODO
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
}
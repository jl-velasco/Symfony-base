<?php
declare(strict_types=1);

namespace Symfony\Base\VideoProyection\Infrastructure;

use Doctrine\DBAL\Exception;
use MongoDB\Collection;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\Repository\Mongo;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Shared\Infrastructure\Mongo\MongoDBDocumentConverter;
use Symfony\Base\VideoProyection\Domain\Video;
use Symfony\Base\VideoProyection\Domain\VideoRepository;

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
     * @throws Exception
     * @throws InvalidValueException
     * @throws PersistenceLayerException
     */
    public function search(Uuid $id): Video|null
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


    public function save(Video $video): void
    {
        try {
            $this->collection->updateOne(
                ['id' => $video->uuid()->value()],
                ['$set' => $video->toArray()],
                ['upsert' => true]
            );
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

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

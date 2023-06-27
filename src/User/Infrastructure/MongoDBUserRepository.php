<?php
declare(strict_types=1);

namespace Symfony\Base\User\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use MongoDB\Collection;
use Symfony\Base\Shared\Domain\Exception\InternalErrorException;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\Repository\Mongo;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Shared\Infrastructure\Mongo\MongoDBDocumentConverter;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;

class MongoDBUserRepository implements UserRepository
{
    private const COLLECTION = 'user';
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
    public function search(Uuid $id): User|null
    {
        try {
            $user = $this->collection->findOne([
                    'id' => $id->value(),
                ]);

            if ($user) {
                return User::fromArray(MongoDBDocumentConverter::toArray($user));
            }

            return null;
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }


    public function save(User $user): void
    {
        try {
            $this->collection->updateOne(
                ['id' => $user->id()->value()],
                ['$set' => $user->toArray()],
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

<?php
declare(strict_types=1);

namespace Symfony\Base\Registation\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Base\Shared\Domain\Exception\InternalErrorException;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Registation\Domain\User;
use Symfony\Base\Registation\Domain\UserRepository;

class MySQLUserRepository implements UserRepository
{
    private const TABLE_USER = 'user';

    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    /**
     * @throws Exception
     * @throws InvalidValueException
     * @throws PersistenceLayerException
     */
    public function search(Uuid $id): User|null
    {
        try {
            $user = $this->connection
                ->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE_USER)
                ->where('id = :id')
                ->setParameter('id', $id->value())
                ->executeQuery()
                ->fetchAssociative();

            if ($user) {
                return User::fromArray($user);
            }

            return null;
        } catch (Exception $e) {
            throw new PersistenceLayerException($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function save(User $user): void
    {
        if ($this->search($user->id())) {
            $this->update($user);
        } else {
            $this->insert($user);
        }
    }

    /**
     * @throws Exception
     */
    private function update(User $user): void
    {
        $this->connection->createQueryBuilder()
            ->update(self::TABLE_USER)
            ->set('email', ':email')
            ->set('name', ':name')
            ->set('password', ':password')
            ->set('updated_at', ':updated_at')
            ->set('video_counter', ':video_counter')
            ->where('id = :id')
            ->setParameters([
                'id' => $user->id(),
                'email' => $user->email(),
                'name' => $user->name(),
                'password' => $user->password(),
                'updated_at' => new Date(),
                'video_counter' => $user->videoCounter()
            ])
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function delete(Uuid $id): void
    {
        $this->connection->delete(
            self::TABLE_USER,
            ['id' => $id]
        );
    }

    /**
     * @throws Exception
     */
    private function insert(User $user): void
    {
        $this->connection->insert(
            self::TABLE_USER,
            [
                'id' => $user->id()->value(),
                'email' => $user->email()->value(),
                'name' => $user->name()->value(),
                'password' => $user->password()->value(),
                'created_at' => $user->createdAt()->stringDateTime(),
            ]
        );
    }
}
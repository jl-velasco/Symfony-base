<?php
declare(strict_types=1);

namespace Symfony\Base\User\Infrastructure;

use Doctrine\DBAL\Connection;
use Symfony\Base\Shared\Infrastructure\Exceptions\SqlConnectionException;
use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Dominio\Exceptions\UserNotFoundException;
use Symfony\Base\User\Dominio\User;
use Symfony\Base\User\Dominio\UserRepository;

class MySQLUserRepository implements UserRepository
{
    public const TABLE = 'user';

    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function save(User $user): User
    {
        try {
            if (!is_null($entity = $this->search($user->id()))) {
                $this->connection->update(
                    self::TABLE,
                    $user->toPrimitives(),
                    [
                        'id' => $entity->id()->value()
                    ]
                );
            } else
                $this->connection->insert(
                    self::TABLE,
                    $user->toPrimitives(),
                );
        }
        catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }

        return $this->search($user->id());
    }

    public function search(Uuid $id): User|null
    {
        try {
            $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE)
                ->where('id = :id')
                ->setParameter('id', $id->value())
                ->executeQuery()
                ->fetchAssociative();

            if (!$result)
                return null;

            return User::fromPrimitives($result);
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }
    }

    public function searchByEmail(Email $email): User|null
    {
        try {
            $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from(self::TABLE)
                ->where('email = :email')
                ->setParameter('email', $email->value())
                ->executeQuery()
                ->fetchAssociative();

            if (!$result)
                return null;

            return User::fromPrimitives($result);
        } catch (\Exception $e) {
            throw new SqlConnectionException($e);
        }
    }

    public function delete(Uuid $id): void
    {
        if (is_null($this->search($id)))
            throw new UserNotFoundException(sprintf('User not found. ID: %s',$id->value()));

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

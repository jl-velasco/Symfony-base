<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\User\Infrastructure;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Infrastructure\MySQLUserRepository;

class MySQLUserRepositoryTest extends DbalTestCase
{
    private MySQLUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MySQLUserRepository($this->connection);
    }

    protected function createTables(Schema $schema): void
    {
        UserTableConnector::createTable($schema);
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function testCreateUser(): void
    {
        $user = UserMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(UserTableConnector::TABLE_USER));

        $this->repository->save($user);

        $all = $this->fetchAll(UserTableConnector::TABLE_USER);

        self::assertCount(1, $all);
        self::assertEquals($user->id()->value(), $all[0]['id']);
        self::assertEquals($user->name()->value(), $all[0]['name']);
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function testUpdateUser(): void
    {
        $user = UserMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(UserTableConnector::TABLE_USER));
        UserTableConnector::insert(
            $this->connection,
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value(),
            $user->password()->value(),
            $user->videoCounter()->value()
        );
        $oldUser = $this->fetchAll(UserTableConnector::TABLE_USER);
        $user->increaseVideoCounter();

        $this->repository->save($user);

        $lastUser = $this->fetchAll(UserTableConnector::TABLE_USER);
        self::assertEquals($oldUser[0]['video_counter'] + 1 , $lastUser[0]['video_counter']);
    }

    /**
     * @throws InvalidValueException
     * @throws Exception
     */
    public function testSearchUser(): void
    {
        $userMother = UserMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(UserTableConnector::TABLE_USER));
        UserTableConnector::insert(
            $this->connection,
            $userMother->id()->value(),
            $userMother->email()->value(),
            $userMother->name()->value(),
            $userMother->password()->value(),
            $userMother->videoCounter()->value()
        );

        $user = $this->repository->search($userMother->id());

        self::assertEquals($user->id()->value(),$userMother->id()->value());
        self::assertEquals($user->name()->value(), $userMother->name()->value());
    }

    public function testDeleteUser(): void
    {
        $userMother = UserMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(UserTableConnector::TABLE_USER));
        UserTableConnector::insert(
            $this->connection,
            $userMother->id()->value(),
            $userMother->email()->value(),
            $userMother->name()->value(),
            $userMother->password()->value(),
            $userMother->videoCounter()->value()
        );

        self::assertCount(1, $this->fetchAll(UserTableConnector::TABLE_USER));
        $this->repository->delete($userMother->id());
        self::assertCount(0, $this->fetchAll(UserTableConnector::TABLE_USER));
    }
}

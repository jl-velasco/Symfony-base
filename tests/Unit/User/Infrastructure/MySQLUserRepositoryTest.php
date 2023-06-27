<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\User\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Registater\Infrastructure\MongoDBUserRepository;
use Doctrine\DBAL\Exception;

class MySQLUserRepositoryTest extends DbalTestCase
{
    private MongoDBUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MongoDBUserRepository($this->connection);
    }

    protected function createTables(Schema $schema): void
    {
        UserTableConnector::createTable($schema);
    }

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

    /** @test */
    public function shouldFailWhenTheConnectionFails(): void
    {
        $connectionMock = $this->createMock(Connection::class);
        $repository = new MongoDBUserRepository($connectionMock);

        $connectionMock->expects(self::once())
            ->method('createQueryBuilder')
            ->willThrowException(new Exception());

        $this->expectException(PersistenceLayerException::class);

        $repository->search(Uuid::random());
    }

    /** @test */
    public function shouldFailWhenTheConnectionOk(): void
    {
        $userMother = UserMother::create()->random()->build();

        $connectionMock = $this->createMock(Connection::class);
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        $resultMock = $this->createMock(Result::class);

        $repository = new MongoDBUserRepository($connectionMock);

        $connectionMock->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilderMock);

        $queryBuilderMock->expects($this->once())
            ->method('select')
            ->with('*')
            ->willReturnSelf();

        $queryBuilderMock->expects($this->once())
            ->method('from')
            ->with('user')
            ->willReturnSelf();

        $queryBuilderMock->expects($this->once())
            ->method('where')
            ->with('id = :id')
            ->willReturnSelf();

        $queryBuilderMock->expects($this->once())
            ->method('setParameter')
            ->with('id', $userMother->id()->value())
            ->willReturnSelf();

        $queryBuilderMock->expects($this->once())
            ->method('executeQuery')
            ->willReturn($resultMock);

        $resultMock->expects($this->once())
            ->method('fetchAssociative')
            ->willReturn($userMother->toArray());

        $user = $repository->search($userMother->id());

        self::assertEquals($user->id()->value(),$userMother->id()->value());
    }
}
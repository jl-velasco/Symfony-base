<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Infrastructure\MySQLVideoRepository;

class MySQLVideoRepositoryTest extends DbalTestCase
{
    private MySQLVideoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MySQLVideoRepository($this->connection);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::createTable($schema);
    }

    public function testCreateVideo() : void
    {
        $video = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->save($video);
        $all = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        self::assertCount(1, $all);
        self::assertEquals($video->uuid()->value(), $all[0]['id']);
        self::assertEquals($video->name()->value(), $all[0]['name']);
    }

    public function testUpdateVideo(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert(
            $this->connection, $video
        );
        $oldVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        $video->changeDescription("New descripcion");
        $this->repository->save($video);

        $lastVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        self::assertNotEquals($oldVideo[0]['description'], $lastVideo[0]['description']);
    }

    public function testSearchVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection, $videoMother
        );
        $video = $this->repository->find($videoMother->uuid());
        self::assertEquals($video->uuid()->value(),$videoMother->uuid()->value());
        self::assertEquals($video->name()->value(), $videoMother->name()->value());
    }

    public function testDeleteVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection, $videoMother
        );
        self::assertCount(1, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->delete($videoMother->uuid());
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
    }

    public function testSearchByUserId(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection, $videoMother
        );
        $videos = $this->repository->findByUserId($videoMother->userUuid());
        self::assertEquals($videos->first()->userUuid()->value(),$videoMother->userUuid()->value());
        self::assertEquals($videos->first()->name()->value(), $videoMother->name()->value());
    }

    public function testAddComment(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        $commentMother = CommentMother::create()->random()->build();
        $countCommentsInVideoOld = count($videoMother->comments());
        $this->repository->save($videoMother);
        $videoMother->addComment($videoMother->uuid(), $commentMother->message());
        self::assertEquals($countCommentsInVideoOld+1, count($videoMother->comments()));
    }

    /** @test TODO*/
    public function shouldFailWhenTheConnectionFails(): void
    {
        $connectionMock = $this->createMock(Connection::class);
        $repository = new MySQLVideoRepository($connectionMock);

        $connectionMock->expects(self::once())
            ->method('createQueryBuilder')
            ->willThrowException(new PersistenceLayerException('co'));

        self::expectException(PersistenceLayerException::class);

    }
}
<?php

namespace Symfony\Base\Tests\Unit\Video\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Infrastructure\MySQLVideoRepository;
use Doctrine\DBAL\Exception;

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
        VideoTableConnector::create($schema);
    }

    public function testCreateVideo(): void
    {
        $video = VideoMother::create()->random()->build();
        self::assertEmpty($this->fetchAll(VideoTableConnector::TABLE_VIDEO));

        $this->repository->save($video);

        $allVideos = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        self::assertNotEmpty($allVideos);
        self::assertEquals($video->uuid()->value(), $allVideos[0]['id']);
        self::assertEquals($video->url()->value(), $allVideos[0]['url']);
    }

    public function testUpdateVideo(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection, $video);
        $oldVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        $video->changeDescription('New description');
        $this->repository->save($video);

        $lastUser = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        self::assertNotEquals($oldVideo[0]['description'], $lastUser[0]['description']);
    }

    public function testUpdateVideoWithComments(): void
    {
        $video = VideoMother::create()->random()->build();
        $comment = CommentMother::create()->random()->build();
        VideoTableConnector::insert($this->connection, $video);
        $oldComments = $this->fetchAll(VideoTableConnector::TABLE_COMMENT);
        self::assertCount($video->comments()->count(), $oldComments);

        $video->addComment($comment->id(), $comment->message());
        $this->repository->save($video);

        $lastComments = $this->fetchAll(VideoTableConnector::TABLE_COMMENT);

        self::assertNotCount(count($oldComments), $lastComments);
    }

    public function testDeleteVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $videoMother
        );

        self::assertNotEmpty($this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->delete($videoMother->uuid());
        self::assertEmpty($this->fetchAll(VideoTableConnector::TABLE_VIDEO));
    }

    public function testFindVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $videoMother
        );

        $video = $this->repository->find($videoMother->uuid());

        self::assertEquals($video->uuid()->value(), $videoMother->uuid()->value());
        self::assertEquals($video->name()->value(), $videoMother->name()->value());
    }

    public function testFindVideosByUserId(): void
    {
        //TODO
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $videoMother
        );

        $videos = $this->repository->findByUserId($videoMother->userUuid());

        self::assertNotEmpty($videos);
    }

    /** @test */
    public function shouldFailWhenTheConnectionFails(): void
    {
        $connectionMock = $this->createMock(Connection::class);
        $repository = new MySQLVideoRepository($connectionMock);

        $connectionMock->expects(self::once())
            ->method('createQueryBuilder')
            ->willThrowException(new Exception());

        self::expectException(PersistenceLayerException::class);

        $repository->find(Uuid::random());
    }
}
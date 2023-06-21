<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\Video\Infrastructure;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Infrastructure\MySQLVideoRepository;

class MySQLVideoRepositoryTest extends DbalTestCase
{
    private MySQLVideoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MySQLVideoRepository($this->connection);
    }

    /**
     * @throws SchemaException
     */
    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }

    public function testCreateVideo(): void
    {
        $video = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));

        $this->repository->save($video);

        $all = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        self::assertCount(1, $all);
        self::assertEquals($video->uuid()->value(), $all[0]['id']);
        self::assertEquals($video->userUuid()->value(), $all[0]['user_id']);
        self::assertEquals($video->name()->value(), $all[0]['name']);
        self::assertEquals($video->description()->value(), $all[0]['description']);
        self::assertEquals($video->url()->value(), $all[0]['url']);
    }

    public function testUpdateVideo(): void
    {
        $video = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        $oldVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        $video->addComment(Uuid::random(), new CommentMessage('test'));
        $this->repository->save($video);

        $videoAfterSave = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        self::assertEquals($oldVideo[0]['comment_counter'] + 1 , $videoAfterSave[0]['comment_counter']);
    }

    public function testSearchVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $videoMother
        );

        $video = $this->repository->find($videoMother->uuid());

        self::assertEquals($video->uuid()->value(),$videoMother->uuid()->value());
        self::assertEquals($video->name()->value(), $videoMother->name()->value());
        self::assertEquals($video->url()->value(), $videoMother->url()->value());
        self::assertEquals($video->description()->value(), $videoMother->description()->value());
    }

    public function testDeleteVideo(): void
    {
        $videoMother = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $videoMother
        );

        self::assertCount(1, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->delete($videoMother->uuid());
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
    }
}

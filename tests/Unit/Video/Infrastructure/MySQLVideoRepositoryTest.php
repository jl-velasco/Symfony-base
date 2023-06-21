<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\Video\Infrastructure;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\UserTableConnector;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\User\UserMother;
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

    public function testUpdateUser(): void
    {
        $video = VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection, $video
        );
        $oldVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        $this->repository->save($video);
        $lastVideo = $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        self::assertEquals($oldVideo[0]['description'], $lastVideo[0]['description']);


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
}
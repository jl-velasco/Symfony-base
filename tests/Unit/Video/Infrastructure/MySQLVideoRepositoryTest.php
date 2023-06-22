<?php

namespace Symfony\Base\Tests\Unit\Video\Infrastructure;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Infrastructure\MySQLVideoRepository;

class MySQLVideoRepositoryTest extends DbalTestCase
{
    private MySQLVideoRepository $repository;

    protected function setUp():void
    {
        parent::setUp();
        $this->repository= new MySQLVideoRepository($this->connection);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }


    /**
     * @throws InvalidValueException
     * @throws Exception
     * @throws PersistenceLayerException
     */
    public function testCreateVideo(): void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->save($video);
        $all= $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        self::assertCount(1, $all);
        self::assertEquals($video->uuid()->value(), $all[0]['id']);


    }


    /**
     * @throws PersistenceLayerException
     * @throws Exception
     * @throws InvalidValueException
     */
    public function testFindVideoOK() :void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        self::assertCount(1, $this ->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $videoDB= $this->repository->find($video->uuid());
        self::assertEquals($video->uuid()->value(),$videoDB->uuid()->value());

    }

    /**
     * @throws PersistenceLayerException
     * @throws Exception
     * @throws InvalidValueException
     */
    public function testFindVideoNotOK() :void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        self::assertCount(1, $this ->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $videoDB= $this->repository->find(new Uuid('2'));
       self::assertNull($videoDB);

    }

    /**
     * @throws Exception
     * @throws InvalidValueException
     */
    public function testFindVideoByUSerId() :void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        self::assertCount(1, $this ->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $videoDb= $this->repository->findByUserId($video->userUuid());
        self::assertEquals($video->uuid()->value(), $videoDb->first()->uuid()->value());
        self::assertEquals($video->userUuid()->value(), $videoDb->first()->userUuid()->value());
    }


    /**
     * @throws Exception
     */
    public function testDeleteVideo() :void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        self::assertCount(1, $this ->fetchAll(VideoTableConnector::TABLE_VIDEO));
        $this->repository->delete($video->uuid());
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
    }


    /**
     * @throws InvalidValueException
     * @throws PersistenceLayerException
     * @throws Exception
     */
    public function testUpdateVideo(): void
    {
        $video= VideoMother::create()->random()->build();
        self::assertCount(0, $this->fetchAll(VideoTableConnector::TABLE_VIDEO));
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        $oldVideo= $this->fetchAll(VideoTableConnector::TABLE_VIDEO);

        $video->changeDescription('nueva descripcion');
        $this->repository->save($video);

        $lastVideo= $this->fetchAll(VideoTableConnector::TABLE_VIDEO);
        self::assertNotEquals($oldVideo[0]['description'], $lastVideo[0]['description']);


    }

}

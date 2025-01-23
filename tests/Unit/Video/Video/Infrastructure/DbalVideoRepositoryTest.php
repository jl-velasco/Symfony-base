<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Infrastructure;

use Fixtures\BD\VideoTableConnector;
use Symfony\Base\Tests\DbalTestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\VideoMother;
use Symfony\Base\Video\Video\Infrastructure\DbalVideoRepository;

class DbalVideoRepositoryTest extends DbalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new DbalVideoRepository($this->connection());
    }

    public function testSaveVideo(): void
    {
        $videoMother = VideoMother::create()->build();

        $this->repository->save($videoMother);

        $video = $this->fetchAll('video');

        $this->assertCount(1, $video);
        $this->assertEquals($videoMother->id()->value(), $video[0]['id']);
        $this->assertEquals($videoMother->url()->value(), $video[0]['url']);
        $this->assertEquals($videoMother->name()->value(), $video[0]['name']);
        $this->assertEquals($videoMother->description()->value(), $video[0]['description']);
    }

    public function testUpdateVideo(): void
    {
        $videoMother = VideoMother::create()->build();
        $this->repository->save($videoMother);
        $video = $this->fetchAll('video');
        $videoMother->increaseLikes();

        $this->repository->save($videoMother);

        $videoUpdated = $this->fetchAll('video');
        $this->assertEquals($video[0]['likes'] + 1, $videoUpdated[0]['likes']);
    }

    public function testSearchVideo(): void
    {
        $videoMother = VideoMother::create()->build();
        VideoTableConnector::insert($this->connection(), $videoMother);
        $video = $this->fetchAll('video');
        $this->assertCount(1, $video);
        $searchVideo = $this->repository->search($videoMother->id());
        $this->assertEquals($videoMother->id()->value(), $searchVideo->id()->value());
    }

    protected function testDeleteVideo(): void
    {
        $videoMother = VideoMother::create()->build();
        VideoTableConnector::insert($this->connection(), $videoMother);
        $video = $this->fetchAll('video');
        $this->assertCount(1, $video);
        $this->repository->delete($videoMother->id());
        $video = $this->fetchAll('video');
        $this->assertCount(0, $video);
    }
}
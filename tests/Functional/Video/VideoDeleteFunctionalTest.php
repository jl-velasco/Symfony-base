<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoDeleteFunctionalTest extends FunctionalTestCase
{
    public function testDeleteVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection, $video);

        $response = $this->doJsonRequest(
            'DELETE',
            "/v1/video/{$video->uuid()->value()}",
            []
        );
        self::assertEquals(204, $response->getStatusCode());

        $videos = $this->getAllFromRepository('video');
        self::assertCount(0, $videos);
        $comments = $this->getAllFromRepository('comment');
        self::assertCount(0, $comments);
    }

    public function testDeleteVideoShouldKo(): void
    {
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'DELETE',
            "/v1/video/{$video->uuid()->value()}",
            []
        );
        self::assertEquals(404, $response->getStatusCode());
    }


    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
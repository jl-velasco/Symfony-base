<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoGetFunctionalTest extends FunctionalTestCase
{
    public function testGetVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        VideoTableConnector::insert($this->connection, $video);

        $response = $this->doJsonRequest(
            'Get',
            "/v1/video/{$video->uuid()->value()}",
            []
        );
        self::assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), TRUE);
        self::assertEquals($video->uuid()->value(), $content['uuid']);
        self::assertEquals($video->url()->value(), $content['url']);
    }

    public function testGetVideoShouldKo(): void
    {
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'Get',
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
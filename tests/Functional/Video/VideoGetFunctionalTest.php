<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoGetFunctionalTest extends FunctionalTestCase
{
    public function testGetVideoShouldOk() :void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection,$video);
        $response = $this->doJsonRequest(
            'GET',
            "/v1/video/{$video->uuid()->value()}",
            []
        );
        self::assertEquals(200, $response->getStatusCode());
        /* Es una manera valida
        $videoArr = $this->getAllFromRepository('video');
        */
        $content = json_decode($response->getContent(), TRUE);
        self::assertEquals($video->uuid()->value(), $content['uuid']);
        self::assertEquals($video->description()->value(), $content['description']);
    }

    public function testGetVideoShouldNoOk() : void
    {
        $video = VideoMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'GET',
            "/v1/video/{$video->uuid()->value()}",
            []
        );
        self::assertNotEquals(200, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }

}
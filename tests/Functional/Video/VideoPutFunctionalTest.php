<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoPutFunctionalTest extends FunctionalTestCase
{
    public function testCreateVideoShouldOk() : void
    {
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/" . $video->uuid()->value(),
            [
                'user_uuid' => $video->userUuid()->value(),
                'name'=> $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value()
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
        // comprobar que en el repositorio de listado de video el primer es el metido
        $videos = $this->getAllFromRepository('video');
        self::assertEquals($video->uuid()->value(), $videos[0]['id']);
    }

    public function testCreateVideoShouldNoOk() : void
    {
        $video = VideoMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/" . $video->uuid()->value(),
            [
                'user_uuid' => $video->userUuid()->value(),
                'name'=> $video->name()->value(),
                'description' => $video->description()->value(),
                // quitamos el url el cual es obligatorio
            ]
        );
        self::assertNotEquals(200, $response->getStatusCode());
    }

    public function testUpdateVideoShouldOk() : void
    {
        $videoOld = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection,$videoOld);
        $oldDescription = $videoOld->description()->value();
        $videoOld->changeDescription("New description");

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/" . $videoOld->uuid()->value(),
            [
                'user_uuid' => $videoOld->userUuid()->value(),
                'name'=> $videoOld->name()->value(),
                'description' => $oldDescription,
                'url' => $videoOld->url()->value()
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
        $videos = $this->getAllFromRepository('video');
        self::assertNotEquals($oldDescription, $videos[0]['description']);
    }




    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
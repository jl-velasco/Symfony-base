<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
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
    }

    public function testAddCommentVideoShouldOk() : void
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
        $comment = CommentMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'POST',
            "/v1/comment/"
            [
                'video_id' => $video->userUuid()->value(),
                'message'=> $comment->message()->value()
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
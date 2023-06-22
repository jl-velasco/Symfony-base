<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoPutFunctionalTest extends FunctionalTestCase
{
    public function testCreateVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            [
                'user_uuid' => $video->userUuid()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
            ]
        );
        self::assertEquals(200, $response->getStatusCode());

        $videos = $this->getAllFromRepository('video');
        self::assertEquals($video->uuid()->value(), $videos[0]['id']);
    }

    public function testUpdateVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection, $video);
        $oldDescription = $video->description()->value();
        $video->changeDescription('New description');

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            [
                'user_uuid' => $video->userUuid()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
            ]
        );
        self::assertEquals(200, $response->getStatusCode());

        $videos = $this->getAllFromRepository('video');
        self::assertNotEquals($oldDescription, $videos[0]['description']);
    }

    public function testUpsertVideoShouldKo(): void
    {
        $video = VideoMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            [
                'user_uuid' => $video->userUuid()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value()
            ]
        );
        self::assertEquals(500, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
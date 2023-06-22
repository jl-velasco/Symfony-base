<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoDeleteFunctionalTest extends FunctionalTestCase
{
    public function testDeleteUserShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'PUT',
            "/api/video/{$video->uuid()->value()}",
            [
                'userId' => $video->userUuid()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value(),
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
    }


    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}

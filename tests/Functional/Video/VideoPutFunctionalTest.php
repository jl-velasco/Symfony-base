<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;
use Symfony\Base\Video\Domain\Video;

class VideoPutFunctionalTest extends FunctionalTestCase
{
    public function testCreateVideoShouldOk(): void
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

    public function dataProviderForCreateVideo(): array
    {
        $video = VideoMother::create()->random()->build();
        return [
            'name is empty' => [
                'params' => [
                    'uuid' => Uuid::random(),
                    'userId' => Uuid::random(),
                    'name' => '',
                    'description' => $video->description()->value(),
                    'url' => $video->url()->value(),
                    'expected' => 200
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCreateVideo
     */
    public function testCreateVideoShouldKo($params): void
    {
        $video = new Video(
            $params['uuid'],
            $params['userId'],
            new Name($params['name']),
            new Description($params['description']),
            new Url($params['url']),
        );

        VideoTableConnector::insert(
            $this->connection,
            $video,
        );

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

        self::assertEquals($params['expected'], $response->getStatusCode());

    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}

<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;


use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;


class UpsertVideFunctionalTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testCreateVideoShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'PUT',
            "v1/video/{$video->uuid()->value()}",
            [
                'user_uuid' => $video->userUuid()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value()
            ]);
        self::assertEquals(200, $response->getStatusCode());
        $videos = $this->getAllFromRepository('video');
        self::assertEquals($video->uuid()->value(), $videos[0]['id']);
    }

    public function dataProviderForUpsertVideo(): array
    {
        return [
            'description is empty' => [
                'params' => [
                    'user_id'=>'f0303ca2-9476-40b4-8f01-2ae0c58c72b9',
                    'name' => 'Juan',
                    'description' => '',
                    'url' => 'url',
                    'expected' => 201
                ],
            ],
            'name is empty' => [
                'params' => [
                   'user_id'=>'f0303ca2-9476-40b4-8f01-2ae0c58c72b9',
                    'name' => '',
                    'description' => 'Video relacionado con...',
                    'url' => 'url1',
                    'expected' => 201
                ],
            ],
            'user_id is empty' => [
                'params' => [
                    'user_id'=>'',
                    'name' => 'Patricia',
                    'description' => 'Video relacionado con...',
                    'url' => 'url2',
                    'expected' => 201
                ],
            ]
        ];
    }
    /**
     * @dataProvider dataProviderForUpsertVideo
     * @throws InvalidValueException
     */
public function testUpsertVideoShouldKo():void
{
    $video = VideoMother::create()->random()->build();
    VideoTableConnector::insert(
        $this->connection,
        $video
    );
    $response = $this->doJsonRequest(
        'DELETE',
        "/v1/video/{$video->uuid()->value()}",
        []
    );
    self::assertEquals(500, $response->getStatusCode());
}

protected function createTables(Schema $schema): void
{
    VideoTableConnector::create($schema);
}
}

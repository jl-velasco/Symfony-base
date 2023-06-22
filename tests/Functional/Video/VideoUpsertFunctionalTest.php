<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;
use Symfony\Base\Video\Domain\Video;

class VideoUpsertFunctionalTest extends FunctionalTestCase
{
    public function testCreateShouldOk(): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            [
                'user_id' => $video->userUuid()->value() ,
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
                'url' => $video->url()->value()
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
    }

    public function dataProviderForCreateVideo(): array
    {
        return [
            'email is empty' => [
                'params' => [
                    'email' => '',
                    'name' => 'name',
                    'password' => 'password',
                    'expected' => 400
                ],
            ],
            'name is empty' => [
                'params' => [
                    'email' => 'email@email.com',
                    'name' => '',
                    'password' => 'password',
                    'expected' => 200
                ],
            ],
        ];
    }

    public function dataProviderForUpdateKoVideo(): array
    {
        return [
            'update failed' => [
                'params' => [
                    'user_id' => 'adasd',
                    'name' => '11111',
                    'description' => 'sfsdf',
                    'url' => 'oogle.es',
                    'expected' => 500
                ],
            ]
        ];
    }

    public function dataProviderForUpdateVideo(): array
    {
        return [
            'update ok' => [
                'params' => [
                    'user_id' => 'adasd',
                    'name' => 'nombre',
                    'description' => 'sfsdf',
                    'url' => 'http://www.google.es'
                ],
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForCreateVideo
     */
    public function testCreateVideoShouldKo($params): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();

        VideoTableConnector::insert(
            $this->connection,
            $video
        );

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            []
        );

        self::assertResponseStatusCodeSame(500);
    }

    /**
     * @dataProvider dataProviderForUpdateVideo
     */
    public function testUpdateVideoShouldOk($params): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();

        VideoTableConnector::insert(
            $this->connection,
            $video
        );

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            $params
        );
        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @dataProvider dataProviderForUpdateKoVideo
     */
    public function testUpdateVideoShouldKo($params): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();

        VideoTableConnector::insert(
            $this->connection,
            $video
        );

        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$video->uuid()->value()}",
            $params
        );
        self::assertResponseStatusCodeSame(500);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
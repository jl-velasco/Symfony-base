<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class GetVideoControllerTest extends FunctionalTestCase
{
    private const VERB = 'GET';
    private const ENDPOINT = '/v1/video/{{uuid}}';

    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenRequestedVideoExistsThenShouldReturnOk(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $video->uuid()->value(), self::ENDPOINT),
            []
        );
        self::assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), TRUE);
        self::assertEquals($video->uuid()->value(), $content['uuid']);
    }

    public function whenRequestedVideoDoesNotExistsThenShouldReturnKo(): void
    {
        $uuid = Uuid::random()->value();
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $uuid, self::ENDPOINT),
            []
        );
        self::assertEquals(404, $response->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}

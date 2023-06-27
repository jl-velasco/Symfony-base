<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;
use Symfony\Base\Video\Studio\Domain\Video;

class UpsertVideoTest extends FunctionalTestCase
{
    private const VERB = 'PUT';
    private const ENDPOINT = '/v1/video/{{uuid}}';

    /**
     * @test
     * @throws InvalidValueException|Exception
     */
    public function whenVideoDoesNotExistsThenShouldBeCreated(): void
    {
        $video = VideoMother::create()->random()->build();
        $videos = $this->getAllFromRepository(VideoTableConnector::TABLE_VIDEO);
        $this->assertCount(0, $videos);
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $video->uuid()->value(), self::ENDPOINT),
            [
                'user_uuid' => $video->userUuid()->value(),
                'url' => $video->url()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
        $videos = $this->getAllFromRepository(VideoTableConnector::TABLE_VIDEO);
        $this->assertCount(1, $videos);
        $this->assertEquals($video->uuid()->value(), $videos[0]['id']);
        $this->assertEquals($video->userUuid()->value(), $videos[0]['user_id']);
        $this->assertEquals($video->url()->value(), $videos[0]['url']);
        $this->assertEquals($video->name()->value(), $videos[0]['name']);
        $this->assertEquals($video->description()->value(), $videos[0]['description']);
    }

    /**
     * @test
     * @throws InvalidValueException|Exception
     */
    public function whenVideoExistsThenShouldBeUpdated(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert(
            $this->connection,
            $video
        );
        $videos = $this->getAllFromRepository(VideoTableConnector::TABLE_VIDEO);
        $this->assertCount(1, $videos);
        $video = new Video(
            $video->uuid(),
            $video->userUuid(),
            new Name('new name'),
            new Description('new description'),
            new Url('https://new.url.com')
        );
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $video->uuid()->value(), self::ENDPOINT),
            [
                'user_uuid' => $video->userUuid()->value(),
                'url' => $video->url()->value(),
                'name' => $video->name()->value(),
                'description' => $video->description()->value(),
            ]
        );
        self::assertEquals(200, $response->getStatusCode());
        $videos = $this->getAllFromRepository(VideoTableConnector::TABLE_VIDEO);
        $this->assertCount(1, $videos);
        $this->assertEquals($video->uuid()->value(), $videos[0]['id']);
        $this->assertEquals($video->userUuid()->value(), $videos[0]['user_id']);
        $this->assertEquals($video->url()->value(), $videos[0]['url']);
        $this->assertEquals($video->name()->value(), $videos[0]['name']);
        $this->assertEquals($video->description()->value(), $videos[0]['description']);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
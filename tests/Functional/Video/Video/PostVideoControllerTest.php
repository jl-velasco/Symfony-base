<?php

namespace Symfony\Base\Tests\Functional\Video\Video;

use Fixtures\BD\VideoTableConnector;
use Symfony\Base\Tests\Functional\FunctionalTestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\VideoMother;
use Symfony\Component\HttpFoundation\Response;

class PostVideoControllerTest extends FunctionalTestCase
{
    private const VERB = 'POST';
    private const ENDPOINT = '/v1/video';

    /**
     * @test
     */
    public function whenVideoDoesNotExistsThenShouldBeCreated(): void
    {
        $videoMother = VideoMother::create()->build();

        $response = $this->doJsonRequest(
            self::VERB,
            self::ENDPOINT . '/' . $videoMother->id()->value(),
            [
                'user_id' => $videoMother->userId()->value(),
                'name' => $videoMother->name()->value(),
                'description' => $videoMother->description()->value(),
                'url' => $videoMother->url()->value(),
            ]
        );

        self::assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function whenVideoExistsThenException(): void
    {
        $videoMother = VideoMother::create()->build();
        VideoTableConnector::insert(
            self::$connection,
            $videoMother
        );

        $response = $this->doJsonRequest(
            self::VERB,
            self::ENDPOINT,
            [
                'id' => $videoMother->id()->value(),
                'userId' => $videoMother->userId()->value(),
                'name' => $videoMother->name()->value(),
                'description' => $videoMother->description()->value(),
                'url' => $videoMother->url()->value(),
            ]
        );

        self::assertEquals(Response::HTTP_CONFLICT, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function whenVideoHaventAllData()
    {
        $response = $this->doJsonRequest(
            self::VERB,
            self::ENDPOINT,
            [
                'id' => 'id',
                'userId' => 'userId',
                'name' => 'name',
                'description' => 'description',
            ]
        );

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;
use Symfony\Base\Video\Domain\Comments;

class InsertCommentTest extends FunctionalTestCase
{
    public const VERB = 'POST';
    public const URI = '/v1/comment/{{uuid}}';

    /**
     * @test
     * @throws InvalidValueException|Exception
     */
    public function whenCommentIsPostedThenShouldBeOk(): void
    {
        $comments = $this->getAllFromRepository(VideoTableConnector::TABLE_COMMENT);
        $this->assertCount(0, $comments);
        $video = VideoMother::create()
            ->random()
            ->withComments(new Comments([]))
            ->build();
        VideoTableConnector::insert($this->connection, $video);
        $comment = CommentMother::create()
            ->random()
            ->withVideoId($video->uuid())
            ->build();
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $comment->id()->value(), self::URI),
            [
                'id' => $comment->id()->value(),
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());
        $comments = $this->getAllFromRepository(VideoTableConnector::TABLE_COMMENT);
        $this->assertCount(1, $comments);
    }

    /**
     * @test
     * @throws Exception
     */
    public function whenCommentIsPostedAndVideoDoesNotExistsThenShouldThrownException(): void
    {
        $videos = $this->getAllFromRepository(VideoTableConnector::TABLE_VIDEO);
        $this->assertCount(0, $videos);
        $comments = $this->getAllFromRepository(VideoTableConnector::TABLE_COMMENT);
        $this->assertCount(0, $comments);
        $comment = CommentMother::create()
            ->random()
            ->withVideoId(Uuid::random())
            ->build();
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $comment->id()->value(), self::URI),
            [
                'id' => $comment->id()->value(),
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     * @throws InvalidValueException|Exception
     */
    public function whenTheSameCommentIsPostedTwiceThenOnlyOneShouldBeAdded(): void
    {
        $videoId = Uuid::random();
        $comment = CommentMother::create()
            ->random()
            ->withVideoId($videoId)
            ->build();
        $video = VideoMother::create()
            ->random()
            ->withId($videoId)
            ->withComments(new Comments([$comment]))
            ->build();
        VideoTableConnector::insert($this->connection, $video);
        $comments = $this->getAllFromRepository(VideoTableConnector::TABLE_COMMENT);
        $this->assertCount(1, $comments);
        $response = $this->doJsonRequest(
            self::VERB,
            str_replace('{{uuid}}', $comment->id()->value(), self::URI),
            [
                'id' => $comment->id()->value(),
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());
        $comments = $this->getAllFromRepository(VideoTableConnector::TABLE_COMMENT);
        $this->assertCount(1, $comments);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
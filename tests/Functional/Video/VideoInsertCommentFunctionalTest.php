<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;


use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Symfony\Base\Tests\Fixtures\Comment\CommentMother;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class VideoInsertCommentFunctionalTest extends FunctionalTestCase
{


    /**
     * @throws Exception
     */
    public function testInsertCommentShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();
        VideoTableConnector::insert($this->connection, $video);
        $oldComments = $this->getAllFromRepository('comment');
        $comment = CommentMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'POST',
            "/v1/comment/{$comment->id()->value()}",
            [
                'video_id' => $video->uuid()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        self::assertEquals(201, $response->getStatusCode());

        $comments = $this->getAllFromRepository('comment');
        self::assertCount(count($oldComments) + 1 , $comments);
    }

    public function testInsertCommentShouldKo(): void
    {

        $comment = CommentMother::create()->random()->build();
        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$comment->id()->value()}",
            [
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value()
            ]
        );
        self::assertEquals(500, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testInsertCommentDuplicateShouldNotInsert(): void
    {
        $video = VideoMother::create()
            ->random()
            ->build();

        $comment = CommentMother::create()
            ->random()
            ->withVideoId($video->uuid())
            ->build();
        $response = $this->doJsonRequest(
            'PUT',
            "/v1/video/{$comment->id()->value()}",
            [
                'video_id' => $comment->videoId()->value(),
                'message' => $comment->message()->value()
            ]
        );
        $Comments = $video = VideoMother::create()->random()->build();
        $comment = CommentMother::create()
            ->random()
            ->withVideoId($video->uuid())
            ->build();
        $video->addComment($comment->id(), $comment->message());
        VideoTableConnector::insert($this->connection, $video);

        $comments = $this->getAllFromRepository('comment');

        $response = $this->doJsonRequest(
            'POST',
            "/v1/comment/{$comment->id()->value()}",
            [
                'video_id' => $video->uuid()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        self::assertEquals(201, $response->getStatusCode());

        $newComments = $this->getAllFromRepository('comment');
        self::assertCount(count($comments), $newComments);
    }


    /**
     * @throws SchemaException
     */
    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}

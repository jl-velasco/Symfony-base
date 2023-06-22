<?php

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class CommentInsertFunctionalTest extends FunctionalTestCase
{
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

    public function testInsertCommentDuplicateShouldNotInsert(): void
    {
        $video = VideoMother::create()->random()->build();
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

    public function testInsertCommentShouldKo(): void
    {
        $comment = CommentMother::create()->random()->build();

        $response = $this->doJsonRequest(
            'POST',
            "/v1/comment/{$comment->id()->value()}",
            [
                'video_id' => '',
                'message' => $comment->message()->value(),
            ]
        );
        self::assertEquals(500, $response->getStatusCode());
    }

    public function testInsertCommentVideoNotExistShouldKo(): void
    {
        $video = VideoMother::create()->random()->build();
        $comment = CommentMother::create()->random()->build();
        $comments = $this->getAllFromRepository('comment');

        $response = $this->doJsonRequest(
            'POST',
            "/v1/comment/{$comment->id()->value()}",
            [
                'video_id' => $video->uuid()->value(),
                'message' => $comment->message()->value(),
            ]
        );
        self::assertEquals(404, $response->getStatusCode());

        $commentsAfterInsert = $this->getAllFromRepository('comment');
        self::assertCount(count($comments), $commentsAfterInsert);
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}
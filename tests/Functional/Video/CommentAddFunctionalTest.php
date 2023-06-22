<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional\Video;

use Doctrine\DBAL\Schema\Schema;
use Symfony\Base\Tests\Fixtures\DB\VideoTableConnector;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Tests\Functional\FunctionalTestCase;

class CommentAddFunctionalTest extends FunctionalTestCase
{
    public function testCreateCommentShouldOk(): void
    {
        $video = VideoMother::create()->random()->build();

        VideoTableConnector::insert(
            $this->connection,
            $video
        );

        $comment = CommentMother::create()->random()->withVideo($video->uuid())->build();

        $responseComment = $this->doJsonRequest(
            'PUT',
            "/api/comment/{$comment->id()->value()}",
            [
                'video_id' => $video->uuid()->value(),
                'message' => $comment->message()->value(),
            ]
        );

        self::assertEquals(201, $responseComment->getStatusCode());
    }

    protected function createTables(Schema $schema): void
    {
        VideoTableConnector::create($schema);
    }
}

<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;

class VideoTest extends TestCase
{
    public function testVideoAddComment(): void
    {
        $video = VideoMother::create()->random()->build();
        $this->assertEmpty($video->comments()->items());

        $comment = CommentMother::create()->random()->build();
        $video->addComment($comment->id(), $comment->message());
        $this->assertNotEmpty($video->comments()->items());
    }

    public function testVideoAddCommentEquals(): void
    {
        $video = VideoMother::create()->random()->build();
        $comment = CommentMother::create()->random()->build();
        $video->addComment($comment->id(), $comment->message());

        $addedComment = $video->comments()->firstOf([$comment, 'equals']);
        $this->assertNotNull($addedComment);

        $this->assertEquals($comment->message(), $addedComment->message());
    }

    public function testVideoAddCommentNoDuplicates(): void
    {
        $video = VideoMother::create()->random()->build();
        $comment = CommentMother::create()->random()->build();
        $video->addComment($comment->id(), $comment->message());

        $commentsCount = $video->comments()->count();
        $video->addComment($comment->id(), $comment->message());
        $this->assertEquals($commentsCount, $video->comments()->count());
    }

}
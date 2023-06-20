<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Unit\Video\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentMessage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Symfony\Base\Video\Domain\Video
 */
class VideoTest extends TestCase
{
    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenACommentIsAddedThenShouldBeOnTheList(): void
    {
        $video = VideoMother::create()->random()->build();
        $uuid = Uuid::random();
        $message = new CommentMessage('This is my comment message');
        $video->addComment($uuid, $message);
        $comments = $video->comments();
        $this->assertCount(1, $comments);
        /** @var Comment $comment */
        $comment = $comments->first();
        $this->assertTrue($comment->id()->equals($uuid));
        $this->assertEquals($message->value(), $comment->message()->value());
        $this->assertTrue($comment->videoId()->equals($video->uuid()));
    }

    /**
     * @test
     * @throws InvalidValueException
     */
    public function whenTheSameCommentIsAddedTwiceThenTheCommentShouldNotBeDuplicated()
    {
        $video = VideoMother::create()
            ->random()
            ->withRandomComments()
            ->build();
        $comments = $video->comments();
        $count = $comments->count();
        $uuid = Uuid::random();
        $message = new CommentMessage('This is my comment message');
        $video->addComment($uuid, $message);
        $comments = $video->comments();
        $this->assertCount($count + 1, $comments);
        $video->addComment($uuid, $message);
        $this->assertCount($count + 1, $comments);
    }
}

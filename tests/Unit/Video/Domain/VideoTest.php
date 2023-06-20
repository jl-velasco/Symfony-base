<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\CommentCounter;
use Symfony\Base\Video\Domain\Events\VideoAddedEvent;
use Symfony\Base\Video\Domain\Events\VideoDeletedEvent;

class VideoTest extends TestCase
{

    public function testVideoIsAdded(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->add();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoAddedEvent::class, $var::class);
    }

    public function testVideoIsDeleted(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->delete();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoDeletedEvent::class, $var::class);
    }

    public function testCommentDecrementShouldOk(): void
    {
        $video = VideoMother::create()->random()->withCommentCounter(new CommentCounter(1))->build();
        $this->assertEquals(1, $video->commentCounter()->value());
        $video->deleteComment();
        $this->assertEquals(0, $video->commentCounter()->value());
    }

    public function testCommentIncrementShouldOk(): void
    {
        $video = VideoMother::create()->random()->addComment()->build();
        $this->assertEquals(1, $video->commentCounter()->value());
    }

    public function testUserSubstractVideoWhenCounterIsZero(): void
    {
        $video = VideoMother::create()->random()->build();
        $this->expectException(InvalidArgumentException::class);
        $video->deleteComment();
    }
}

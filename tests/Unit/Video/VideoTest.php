<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Video;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\User\Domain\VideoCounter;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoDeleted;

class VideoTest extends TestCase
{

    public function testVideoisDeleted(): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();
        $video->delete();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoDeleted::class, $var::class);
    }

    public function testVideoAddComment(): void
    {
        /** @var Video $video */
        $video = VideoMother::create()->random()->build();
        $video->addComment(new U);
    }





    public function testUserSubstractShouldOk(): void
    {
        $user = UserMother::create()
            ->random()
            ->withVideoCounter(new VideoCounter(1))
            ->build();

        $this->assertEquals(1, $user->videoCounter()->value());
        $user->substractVideo();
        $this->assertEquals(0, $user->videoCounter()->value());
    }

    public function testUserSubstractVideoWhenCounterIsZero(): void
    {
        $user = UserMother::create()->random()->build();
        $this->expectException(InvalidArgumentException::class);
        $user->substractVideo();
    }
}
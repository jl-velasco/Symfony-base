<?php

namespace Symfony\Base\Tests\Unit\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\VideoCreated;
use Symfony\Base\Video\Domain\VideoDeleted;

class VideoTest extends TestCase
{
    public function testVideoIsCreated(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->save();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoCreated::class, $var::class);
    }

    public function testVideoIsDeleted(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->delete();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoDeleted::class, $var::class);
    }

    public function testAddNewComments(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->addComment();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoCreated::class, $var::class);
    }
}
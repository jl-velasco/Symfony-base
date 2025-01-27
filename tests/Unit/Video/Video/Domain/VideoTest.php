<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\VideoMother;
use Symfony\Base\Video\Video\Domain\Video;
use Symfony\Base\Video\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\Video\Video\Domain\VideoLikes;

class VideoTest extends TestCase
{
    /** @test */
    public function test_video_add_like(): void
    {
        $video = VideoMother::create()->build();
        $video->addLike();
        $video->addLike();
        $video->addLike();
        $video->addLike();

        $this->assertEquals($video->likes()->value(), 4);
    }

    /** @test */
    public function add_likes_with_likes_initialized(): void
    {
        $video = VideoMother::create()->build(likes: new VideoLikes(10));
        $video->addLike();
        $video->addLike();
        $video->addLike();
        $video->addLike();

        $this->assertEquals($video->likes()->value(), 14);
    }

    /** @test */
    public function create_video_publish_event(): void
    {
        $videoMother = VideoMother::create()->build();
        $video = Video::create(
            $videoMother->id()->value(),
            $videoMother->userId()->value(),
            $videoMother->name()->value(),
            $videoMother->description()->value(),
            $videoMother->url()->value()
        );

        $this->assertEquals($video->likes()->value(), 0);
        $events = $video->pullDomainEvents();
        $this->assertCount(1, $events);
        $this->assertEquals(VideoCreatedDomainEvent::class, $events[0]::class);
    }
}
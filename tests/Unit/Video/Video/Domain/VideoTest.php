<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\VideoMother;

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
}
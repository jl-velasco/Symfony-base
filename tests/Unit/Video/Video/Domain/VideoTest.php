<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Domain;

use Mother\Domain\VideoMother;
use PHPUnit\Framework\TestCase;

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

        $this->assertEquals($video->likes(), 4);
    }
}
<?php

namespace Symfony\Base\Tests\Unit\Video\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Video\Video\Domain\VideoLikes;

class VideoLikesTest extends TestCase
{
    /** @test */
    public function test_video_add_like(): void
    {
        $videoLikes = VideoLikes::create();
        $videoLikes = $videoLikes->addLike();
        $videoLikes = $videoLikes->addLike();
        $videoLikes = $videoLikes->addLike();
        $videoLikes = $videoLikes->addLike();

        $this->assertEquals($videoLikes->value(), 4);
    }
}
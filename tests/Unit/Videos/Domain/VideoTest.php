<?php

namespace Symfony\Base\Tests\Unit\Videos\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;

class VideoTest extends TestCase
{
    public function testVideoWithIdNotNull(): self
    {
        $video = VideoMother::create()->random()->build();
        $video->addVideo();
        $this->assertNotNull($video->uuid);
    }
}
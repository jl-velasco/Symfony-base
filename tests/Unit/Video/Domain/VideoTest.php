<?php

namespace Symfony\Base\Tests\Unit\Video\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\Comment\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\VideoDeleted;

class VideoTest extends TestCase
{
    public function testVideoIsDeleted(): void
    {
        $video = VideoMother::create()->random()->build();
        $video->delete();
        $events = $video->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(VideoDeleted::class, $var::class);
    }

    public function testVideoAddCommentShouldOk()
    {
        $video = VideoMother::create()->random()->build();
        $video->save();
        $comment = CommentMother::create()->random()->build();
        $contador=count($video->comments());
        $video->addComment($comment->id(),$comment->message());
        $this->assertEquals($contador+1, count($video->comments()));
    }


}

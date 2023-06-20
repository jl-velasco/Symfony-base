<?php

namespace Symfony\Base\Tests\Unit\Videos\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Video\CommentMother;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;
use Symfony\Base\Video\Domain\CommentMessage;

class VideoTest extends TestCase
{
    public function testVideoAddCommentOk() : void
    {
        $video = VideoMother::create()->random()->build();
        $video->save();
        $comment = CommentMother::create()->random()->build();
        $var = count($video->comments());
        $video->addComment($comment->id(), $comment->message());
        $this->assertEquals($var+1, count($video->comments()));
     }

}
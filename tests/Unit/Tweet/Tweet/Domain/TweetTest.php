<?php

namespace Symfony\Base\Tests\Unit\Tweet\Tweet\Domain;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Unit\Mother\Domain\TweetMother;

class TweetTest extends TestCase
{

    /** @test */
    public function addLikeOnTweet(): void
    {
        $tweet = TweetMother::create()->build();
        $this->assertEquals($tweet->likes()->value(), 0);
        $tweet->addLike();
        $tweet->addLike();
        $tweet->addLike();
        $tweet->addLike();
        $this->assertEquals($tweet->likes()->value(), 4);
    }
}
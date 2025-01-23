<?php

namespace Symfony\Base\Tests\Unit\Mother\Domain;

use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\InvalidValueException;
use Symfony\Base\Shared\Domain\UpdatedAt;
use Symfony\Base\Tests\Unit\Mother\Mother;
use Symfony\Base\Tweet\Shared\Domain\Content;
use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Shared\Domain\UserId;
use Symfony\Base\Tweet\Tweet\Domain\Tweet;
use Symfony\Base\Tweet\Tweet\Domain\TweetLikes;

class TweetMother extends Mother
{
    public static function create(): Mother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     */
    public function build(
        ?TweetId    $id = null,
        ?UserId     $userId = null,
        ?TweetLikes $likes = null,
        ?Content    $content = null,
        ?CreatedAt  $createdAt = null,
        ?UpdatedAt  $updateAt = null,
    ): Tweet
    {
        return new Tweet(
            $id ?? TweetId::random(),
            $userId ?? new UserId($this->faker->uuid()),
            $likes ?? TweetLikes::create(),
            $content ?? new Content($this->faker->text()),
            $createdAt ?? new CreatedAt(),
            $updateAt ?? null,
        );
    }
}
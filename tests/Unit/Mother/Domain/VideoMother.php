<?php

namespace Symfony\Base\Tests\Unit\Mother\Domain;

use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\InvalidValueException;
use Symfony\Base\Shared\Domain\UpdatedAt;
use Symfony\Base\Tests\Unit\Mother\Mother;
use Symfony\Base\Tweet\Shared\Domain\UserId;
use Symfony\Base\Video\Shared\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\Video;
use Symfony\Base\Video\Video\Domain\VideoDescription;
use Symfony\Base\Video\Video\Domain\VideoLikes;
use Symfony\Base\Video\Video\Domain\VideoName;
use Symfony\Base\Video\Video\Domain\VideoUrl;

class VideoMother extends Mother
{
    public static function create(): Mother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     */
    public function build(
        ?VideoId          $id = null,
        ?UserId          $userId = null,
        ?VideoName        $name = null,
        ?VideoDescription $description = null,
        ?VideoUrl         $url = null,
        ?VideoLikes       $likes = null,
        ?CreatedAt        $createdAt = null,
        ?UpdatedAt        $updateAt = null,
    ): Video
    {
        return new Video(
            $id ?? VideoId::random(),
            $userId ?? new UserId($this->faker->uuid()),
            $name ?? new VideoName($this->faker->name()),
            $description ?? new VideoDescription($this->faker->name()),
            $url ?? new VideoUrl($this->faker->url()),
            $likes ?? VideoLikes::create(),
            $createdAt ?? new CreatedAt(),
            $updateAt ?? null,
        );
    }
}
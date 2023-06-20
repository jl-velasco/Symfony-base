<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\Video;


class VideoMother extends Mother
{
    private Uuid $uuid;
    private Uuid $userUuid;
    private Name $name;
    private Description $description;
    private Url $url;

    public static function create(): Mother
    {
        return new self();
    }

    public function random() : self
    {
        $this->uuid = Uuid::random();
        $this->userUuid = Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description = new Description($this->faker->text());
        return $this;
    }

    public function build(): Video
    {
        return new Video(
            $this->uuid,
            $this->userUuid,
            $this->name,
            $this->description
        );
    }





}
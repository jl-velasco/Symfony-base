<?php
declare(strict_types=1);
namespace Symfony\Base\Tests\Fixtures\Video;

use Faker\Factory;
use Faker\Generator;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

abstract class VideoMother
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    abstract public static function create(): VideoMother;


    /**
     * @throws InvalidValueException
     */
    public function random() : self
    {
        $this->uuid = Uuid::random();
        $this->userUuid = Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description = new Description($this->faker->text());
    }
}

<?php
declare(strict_types = 1);
namespace Symfony\Base\Tests\Fixtures\Comment;

use Faker\Factory;
use Faker\Generator;
use Symfony\Base\Tests\Fixtures\Video\VideoMother;

abstract class CommentMother
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    abstract public static function create(): CommentMother;

}

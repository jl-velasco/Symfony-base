<?php
declare(strict_types = 1);
namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Comment\CommentMother;
use Symfony\Base\Tests\Fixtures\Mother;




use Symfony\Base\Video\Domain\Comments;
use Symfony\Base\Video\Domain\Video;

class VideoMother extends Mother
{
    private Uuid $id;
    private Uuid $userUuid;
    private Name $name;
    private Description $description;
    private Url $url;
    private Date $createdAt;
    private Date $updateAt;
    private Comments $comments;

    public static function create(): Mother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     */
    public function random(): self
    {
        $this->id = Uuid::random();

        $this->userUuid=Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description=new Description($this->faker->text());
        $this->url=new Url($this->faker->url());
        $this->createdAt=new Date($this->faker->date());
        $this->updateAt=new  Date($this->faker->date());
        $this->comments= new Comments();
         for ($i=0;$i<$this->faker->randomNumber(1);$i++){
             $this->comments->add(CommentMother::create()->random()->build());
         }

        $this->userUuid = Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description = new Description($this->faker->text());
        $this->url = new Url($this->faker->url());
        $this->createdAt = new Date($this->faker->date());
        $this->updateAt = new  Date($this->faker->date());
        $this->comments = new Comments();
        for ($i = 0; $i < $this->faker->numberBetween(1,10); $i++) {
            $this->comments->add(CommentMother::create()->random()->build());
        }

        return $this;
    }

    public function build(): Video
    {
        return new Video(
            $this->id,
            $this->userUuid,
            $this->name,
            $this->description,
            $this->url,
            $this->createdAt,
            $this->updateAt,
        );
    }

    public function withDescription(Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function withUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function withCreatedAt(Date $date): self
    {
     $this->createdAt= $date;
     return $this;
    }

    public function withUpdatedAt(Date $date): self
    {
        $this->updateAt= $date;
        return $this;

    }
    public function withComments( Comments $value) : self
    {
        $this->comments = $value;
        return $this;
    }


}

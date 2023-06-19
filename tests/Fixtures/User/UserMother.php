<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Fixtures\User;

use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\User\Domain\Password;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\VideoCounter;

class UserMother extends Mother
{

    private Uuid $id;
    private Email $email;
    private Name $name;
    private Password $password;
    private VideoCounter $videoCounter;

    public static function create(): Mother
    {
        return new self();
    }

    public function random(): self
    {
        $this->id = Uuid::random();
        $this->email = new Email($this->faker->email());
        $this->name = new Name($this->faker->name());
        $this->password = new Password($this->faker->password());
        $this->videoCounter = new VideoCounter(0);

        return $this;
    }

    public function build(): User
    {
        return new User(
            $this->id,
            $this->email,
            $this->name,
            $this->password,
            $this->videoCounter
        );
    }

    public function withEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withVideoCounter(VideoCounter $videoCounter): self
    {
        $this->videoCounter = $videoCounter;

        return $this;
    }

}
<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Domain\Events\UserDeletedEvent;
use Symfony\Base\User\Domain\VideoCounter;

class UserTest extends TestCase
{

    public function testUserIsDeleted(): void
    {
        $user = UserMother::create()->random()->build();
        $user->delete();
        $events = $user->pullDomainEvents();
        $var = $events[0];
        $this->assertEquals(UserDeletedEvent::class, $var::class);
    }

    public function testUserAddVideo(): void
    {
        $user = UserMother::create()->random()->build();
        $this->assertEquals(0, $user->videoCounter()->value());
        $user->addVideo();
        $this->assertEquals(1, $user->videoCounter()->value());
    }

    public function testUserSubstractShouldOk(): void
    {
        $user = UserMother::create()
            ->random()
            ->withVideoCounter(new VideoCounter(1))
            ->build();

        $this->assertEquals(1, $user->videoCounter()->value());
        $user->substractVideo();
        $this->assertEquals(0, $user->videoCounter()->value());
    }

    public function testUserSubstractVideoWhenCounterIsZero(): void
    {
        $user = UserMother::create()->random()->build();
        $this->expectException(InvalidArgumentException::class);
        $user->substractVideo();
    }
}

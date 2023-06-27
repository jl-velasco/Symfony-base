<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Registater\Domain\UserDeletedDomainEvent;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Domain\VideoCounter;

class UserTest extends TestCase
{

    /**
     * @throws InvalidValueException
     */
    public function testUserIsDeleted(): void
    {
        $user = UserMother::create()->random()->build();
        $user->delete();
        $events = $user->pullDomainEvents();
        $firtsEvent = $events[0];
        $this->assertEquals(UserDeletedDomainEvent::class, $firtsEvent::class);
    }

    /**
     * @throws InvalidValueException
     */
    public function testUserAddVideo(): void
    {
        $user = UserMother::create()->random()->build();
        $this->assertEquals(0, $user->videoCounter()->value());
        $user->increaseVideoCounter();
        $this->assertEquals(1, $user->videoCounter()->value());
    }

    /**
     * @throws InvalidValueException
     */
    public function testUserSubstractShouldOk(): void
    {
        $user = UserMother::create()
            ->random()
            ->withVideoCounter(new VideoCounter(1))
            ->build();

        $this->assertEquals(1, $user->videoCounter()->value());
        $user->decreaseVideoCounter();
        $this->assertEquals(0, $user->videoCounter()->value());
    }

    /**
     * @throws InvalidValueException
     */
    public function testUserSubstractVideoWhenCounterIsZero(): void
    {
        $user = UserMother::create()->random()->build();
        $this->expectException(InvalidArgumentException::class);
        $user->decreaseVideoCounter();
    }
}
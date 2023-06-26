<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Application;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Aplication\DeleteUserCommandHandler;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserDeletedDomainEvent;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;

class DeleteUserUseCaseTest extends TestCase
{
    private UserRepository&MockObject $repository;
    private UserFinder&MockObject $finder;
    private EventBus&MockObject $bus;
    private DeleteUserCommandHandler $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->finder = $this->createMock(UserFinder::class);
        $this->bus = $this->createMock(EventBus::class);
        $this->useCase = new DeleteUserCommandHandler(
            $this->repository,
            $this->finder,
            $this->bus,
        );
    }

    /**
     * @test
     *
     * @throws UserNotExistException
     * @throws InvalidValueException
     */
    public function deleteUserShouldOk(): void
    {
        $user = UserMother::create()->random()->build();
        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($user->id())
            ->willReturn($user);

        $this->repository
            ->expects(self::once())
            ->method('delete')
            ->with($user->id());

        $this->bus
            ->expects(self::once())
            ->method('publish')
            ->with(self::callback(
                static fn (UserDeletedDomainEvent $event) => ($event->aggregateId() === $user->id()->value())
            ));

        $this->useCase->__invoke($user->id()->value());
    }

}
<?php

namespace Symfony\Base\Tests\Unit\User\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Aplication\GetUserUseCase;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;

class GetUserUseCaseTest extends TestCase
{

    private UserFinder $finder;
    private GetUserUseCase $useCase;

    public function setUp(): void
    {
        $this->finder = $this->createMock(UserFinder::class);
        $this->useCase = new GetUserUseCase($this->finder);

    }

    /**
     * @test
     * @throws UserNotExistException
     * @throws InvalidValueException
     */
    public function getUserUseCaseTest(): void
    {
        $user = UserMother::create()->random()->build();
        $this->finder
            ->expects(self::once())
            ->method('__invoke')
            ->with($user->id())
            ->willReturn($user);
        $this->useCase->__invoke($user->id()->value());
    }
}
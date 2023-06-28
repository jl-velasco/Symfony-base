<?php

namespace Symfony\Base\Tests\Unit\User\Domain;


use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Registation\Domain\Exceptions\UserNotExistException;
use Symfony\Base\Registation\Domain\UserFinder;
use Symfony\Base\Registation\Domain\UserRepository;

class UserFinderTest extends TestCase
{
    private UserRepository $repository;
    private UserFinder $useCase;
    public function setUp() : void
    {
        $this->repository= $this->createMock(UserRepository::class);
        $this->useCase= new UserFinder($this->repository);
    }

    /**
     * @test
     */
    public function whenUserNotExistShouldThrowException():void
    {
        $this->repository
            ->expects(self::once())
            ->method('search')
            ->willReturn(null);
        $this->expectException(UserNotExistException::class);
        $this->useCase->__invoke(new Uuid('123'));
    }
    public function whenUserExistShouldUser() :void
    {
        $userMother= UserMother::create()->random()->build();
        $this->repository
            ->expects(self::once())
            ->method('search')
            ->with($userMother->id())
            ->willReturn($userMother);
       $user= $this->useCase->__invoke($userMother->id());
        self::assertEquals($user->id()->value(), $userMother->id()->value());
    }
}

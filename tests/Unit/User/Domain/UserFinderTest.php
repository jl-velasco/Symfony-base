<?php
<<<<<<< HEAD

namespace Symfony\Base\Tests\Unit\User\Domain;


=======
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Domain;

>>>>>>> 9d87f93f4569f280d7d3db4c8be882ecbcf82417
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
<<<<<<< HEAD
    public function setUp() : void
    {
        $this->repository= $this->createMock(UserRepository::class);
        $this->useCase= new UserFinder($this->repository);
=======

    public function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->useCase = new UserFinder($this->repository);
>>>>>>> 9d87f93f4569f280d7d3db4c8be882ecbcf82417
    }

    /**
     * @test
<<<<<<< HEAD
     */
    public function whenUserNotExistShouldThrowException():void
=======
     * */
    public function whenUserNotExistShouldThrowException(): void
>>>>>>> 9d87f93f4569f280d7d3db4c8be882ecbcf82417
    {
        $this->repository
            ->expects(self::once())
            ->method('search')
            ->willReturn(null);
<<<<<<< HEAD
        $this->expectException(UserNotExistException::class);
        $this->useCase->__invoke(new Uuid('123'));
    }
    public function whenUserExistShouldUser() :void
    {
        $userMother= UserMother::create()->random()->build();
=======

        $this->expectException(UserNotExistException::class);
        $this->useCase->__invoke(new Uuid('123'));
    }

    /**
     * @test
     * */
    public function whenUserExistShouldUser(): void
    {
        $userMother = UserMother::create()->random()->build();
>>>>>>> 9d87f93f4569f280d7d3db4c8be882ecbcf82417
        $this->repository
            ->expects(self::once())
            ->method('search')
            ->with($userMother->id())
            ->willReturn($userMother);
<<<<<<< HEAD
       $user= $this->useCase->__invoke($userMother->id());
        self::assertEquals($user->id()->value(), $userMother->id()->value());
    }
}
=======

        $user = $this->useCase->__invoke($userMother->id());
        self::assertEquals($user->id()->value(), $userMother->id()->value());
    }

}
>>>>>>> 9d87f93f4569f280d7d3db4c8be882ecbcf82417

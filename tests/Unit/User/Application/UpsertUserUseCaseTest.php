<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\User\Aplication\UpsertUserUseCase;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;


class UpsertUserUseCaseTest extends TestCase
{
    private UserRepository $repository;
    private UpsertUserUseCase $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->useCase = new UpsertUserUseCase($this->repository);
    }

    /**
     * @test
     * */
    public function whenSaveUserShouldOk(): void
    {
        $user = UserMother::create()->random()->build();

        $this->repository
            ->expects(self::once())
            ->method('save');

        $this->useCase->__invoke(
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value(),
            $user->password()->value(),
        );

    }

}
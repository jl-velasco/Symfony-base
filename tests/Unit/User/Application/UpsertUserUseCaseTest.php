<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\User\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Base\Tests\Fixtures\User\UserMother;
use Symfony\Base\Registater\Aplication\UpsertUserCommandHandler;
use Symfony\Base\Registater\Domain\User;
use Symfony\Base\Registater\Domain\UserRepository;


class UpsertUserUseCaseTest extends TestCase
{
    private UserRepository $repository;
    private UpsertUserCommandHandler $useCase;

    public function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->useCase = new UpsertUserCommandHandler($this->repository);
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
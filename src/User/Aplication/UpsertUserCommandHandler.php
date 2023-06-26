<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Password;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;

class UpsertUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $repository
    )
    {
    }

    public function __invoke(UpsertUserCommand $command): void
    {
        $this->repository->save(
            new User(
                new Uuid($command->id()),
                new Email($command->email()),
                new Name($command->name()),
                new Password($command->password()),
            )
        );
    }
}
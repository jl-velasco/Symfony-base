<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }

    public function __invoke(UpsertVideoCommand $command): void
    {
        $this->repository->save(
            new Video(
                new Uuid($command->uuid()),
                new Uuid($command->userUuid()),
                new Name($command->name()),
                new Description($command->description()),
                new URL($command->url()),
            )
        );
    }
}
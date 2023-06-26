<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller;



use Symfony\Base\Shared\Domain\Bus\Command\Command;
use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Shared\Domain\Bus\Query\Query;
use Symfony\Base\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Base\Shared\Domain\Bus\Query\Response;

abstract class ApiController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    ) {
    }

    protected function ask(Query $query): Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}

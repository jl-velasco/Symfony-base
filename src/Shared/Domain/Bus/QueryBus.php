<?php

namespace Symfony\Base\Shared\Domain\Bus;

interface QueryBus
{
    public function ask(Query $query): Response;
}
<?php

namespace Symfony\Base\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): Response;
}
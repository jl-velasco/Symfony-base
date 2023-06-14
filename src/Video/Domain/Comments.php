<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Collection;

class Comments extends Collection
{
    protected function type(): string
    {
        return Comment::class;
    }

    public function add(mixed $item): void
    {
        /** @var Comment $item */
        if (!$this->firstOf([$item, 'equals'])) {
            parent::add($item);
        }
    }
}

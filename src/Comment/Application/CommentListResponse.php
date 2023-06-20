<?php

declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\CommentCollection;

final class CommentListResponse
{
    public function __construct(
        private readonly CommentCollection $collection,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        $result = [];
        foreach($this->collection->items() as $item)
            $result[] = $item->toPrimitives();

        return [
            'comments' => $result
        ];
    }
}

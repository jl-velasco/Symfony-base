<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Symfony\Base\Shared\Domain\Exception\InvalidTypeException;

abstract class Collection implements Countable, IteratorAggregate
{
    /**
     * @throws InvalidTypeException
     */
    public function __construct(private readonly array $items)
    {
        Assert::arrayOf($this->type(), $items);
    }

    abstract protected function type(): string;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items());
    }
}

<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @implements IteratorAggregate<TKey, TValue>
 */
abstract class Collection implements Countable, IteratorAggregate
{
    /** @param array<int, mixed> $items */
    public function __construct(private array $items = [])
    {
        Assert::arrayOf($this->type(), $items);
    }

    /** @return ArrayIterator<int, TValue> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return \count($this->items());
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }

    /** @throws Exception */
    public function remove(mixed $itemToRemove): void
    {
        foreach ($this->getIterator() as $key => $item) {
            if ($item === $itemToRemove) {
                unset($this->items[$key]);
            }
        }
    }

    /** @return array<TValue>> */
    public function items(): array
    {
        return $this->items;
    }

    /** @return array<TValue>> */
    public function last(): mixed
    {
        return end($this->items);
    }

    /** @return TValue */
    public function first(): mixed
    {
        return reset($this->items);
    }


    /**
     * @throws Exception
     */
    public function merge(Collection $collection): void
    {
        foreach ($collection->getIterator() as $iterator) {
            if ($this->type() !== \get_class($iterator) && $this->type() !== get_parent_class($iterator)) {
                throw new Exception(
                    sprintf('Items must be <%s> instead of <%s>', \get_class($iterator), $this->type())
                );
            }
            $this->add($iterator);
        }
    }


    public function diff(Collection $collection): static
    {
        return new static(array_udiff(
            (array) $this->getIterator(),
            (array) $collection->getIterator(),
            static fn (mixed $a, mixed $b) => $a->id()->value() <=> $b->id()->value()
        ));
    }

    public function each(callable $callback): array
    {
        return array_map($callback, (array) $this->getIterator());
    }

    public function firstOf(callable $callback): mixed
    {
        foreach ((array) $this->getIterator() as $current) {
            if (call_user_func($callback, $current)) {
                return $current;
            }
        }

        return null;
    }

    abstract protected function type(): string;
}

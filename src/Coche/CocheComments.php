<?php

namespace Symfony\Base\Coche;

use Symfony\Base\Order\OrderItem;
use Symfony\Base\Order\OrderTotal;
use Symfony\Base\Shared\Domain\Collection;

class CocheComments extends Collection
{
    public function toPrimitives()
    {
        return array_map(fn(OrderItem $item) => $item->toPrimitives(), $this->items());
    }

    protected function type(): string
    {
        return CocheComment::class;
    }

    public function total(): OrderTotal
    {
        $total = 0;
        foreach ($this->items() as $item) {
            $total = $total + $item->prive()->value();
        }

        return new OrderTotal($total);
    }
}
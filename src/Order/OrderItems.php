<?php

namespace Symfony\Base\Order;

use Symfony\Base\Shared\Domain\Collection;

class OrderItems extends Collection
{
    public function toPrimitives()
    {
        return array_map(fn(OrderItem $item) => $item->toPrimitives(), $this->items());
    }

    protected function type(): string
    {
        return OrderItem::class;
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
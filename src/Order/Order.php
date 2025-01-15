<?php

namespace Symfony\Base\Order;

class Order
{
    public function __construct(
        private OrderId $id,
        private array $items,
        private OrderTotal $total,
    )
    {
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function total(): OrderTotal
    {
        return $this->total;
    }

    public function equals(Order $other): bool
    {
        return $this->id->equals($other->id);
    }

    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
        $this->total = $this->total->sum(
            $item->total()->value()
        );
    }

    public function removeItem(OrderItem $item): void
    {
        $this->items = array_filter(
            $this->items,
            fn(OrderItem $i) => !$i->equals($item)
        );
        $this->total = $this->total->sub(
            $item->total()->value()
        );
    }
}
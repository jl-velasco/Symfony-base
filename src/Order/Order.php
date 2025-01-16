<?php

namespace Symfony\Base\Order;

class Order
{
    public function __construct(
        private readonly OrderId $id,
        private OrderItems       $items,
        private OrderTotal       $total,
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

    private function addItem(OrderItem $item): void
    {
        if ($this->items->contains($item)) {
            throw new ItemAlreadyExists();
        }
        $this->items[] = $item;
        $this->total = $this->total->sum(
            $item->price()->value()
        );
    }

    public function removeItem(OrderItem $item): void
    {
        $this->items->remove($item);
        $this->total = $this->total->sub(
            $item->price()->value()
        );
    }

    public function save(
        OrderRepository $repository
    ): void
    {
        if ($this->total->value() <= 0) {
            throw new TotalNotValid();
        }

        if ($this->total->value() !== $this->items->total()->value()) {
            throw new TotalNotMatch();
        }

        $this->repository->save($this);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id->value(),
            'items' => $this->items->toPrimitives(),
            'total' => $this->total->value(),
        ];
    }

    public function fromPrimitives(array $primitives): Order
    {
        return new Order(
            new OrderId($primitives['id']),
            new OrderItems(
                array_map(
                    fn(array $item) => OrderItem::fromPrimitives($item),
                    $primitives['items']
                )
            ),
            new OrderTotal($primitives['total'])
        );
    }

    public function addItems($items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function updateTotal($total)
    {
        $this->total = new OrderTotal($total);
    }
}
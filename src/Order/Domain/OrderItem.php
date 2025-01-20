<?php

namespace Symfony\Base\Order\Domain;

class OrderItem
{
    public function __construct(
        private readonly OrderItemId    $id,
        private readonly OrderItemPrice $price,
    )
    {
    }

    public function id(): OrderItemId
    {
        return $this->id;
    }

    public function price(): OrderItemPrice
    {
        return $this->price;
    }

    public function equals(OrderItem $other): bool
    {
        return $this->id->equals($other->id);
    }


}
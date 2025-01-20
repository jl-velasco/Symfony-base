<?php

namespace Symfony\Base\Order\Domain;

interface OrderRepository
{
    public function save(Order $order): void;

    public function find(OrderId $id): ?Order;

    public function delete(OrderId $id): void;
}
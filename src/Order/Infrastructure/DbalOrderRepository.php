<?php

namespace Symfony\Base\Order\Infrastructure;

use Symfony\Base\Order\Connection;
use Symfony\Base\Order\CustomerId;
use Symfony\Base\Order\Domain\Order;
use Symfony\Base\Order\Domain\OrderId;
use Symfony\Base\Order\Domain\OrderRepository;
use Symfony\Base\Order\OrderStatus;

class DbalOrderRepository implements OrderRepository
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function save(Order $order): void
    {
        if ($this->find($order->id()) === null) {
            $this->connection->insert('orders', [
                'id' => $order->id()->value(),
                'customer_id' => $order->customerId()->value(),
                'status' => $order->status()->value(),
                'created_at' => $order->createdAt()->format('Y-m-d H:i:s'),
            ]);
        } else {
            $this->connection->update('orders', [
                'customer_id' => $order->customerId()->value(),
                'status' => $order->status()->value(),
                'created_at' => $order->createdAt()->format('Y-m-d H:i:s'),
            ], [
                'id' => $order->id()->value(),
            ]);
        }
    }

    public function find(OrderId $id): ?Order
    {
        $query = $this->connection->createQueryBuilder()
            ->select('id, customer_id, status, created_at')
            ->from('orders')
            ->where('id = :id')
            ->setParameter('id', $id->value());

        $data = $this->connection->fetchAssoc($query->getSQL(), $query->getParameters());

        if ($data === false) {
            return null;
        }

        return new Order(
            new OrderId($data['id']),
            new CustomerId($data['customer_id']),
            new OrderStatus($data['status']),
            new \DateTimeImmutable($data['created_at'])
        );
    }

    public function delete(OrderId $id): void
    {
        $this->connection->delete('orders', [
            'id' => $id->value(),
        ]);
    }
}
<?php

namespace Symfony\Base\Order\Application;

use Symfony\Base\Order\Domain\OrderId;
use Symfony\Base\Order\Domain\OrderRepository;
use Symfony\Base\Order\OrderNotFound;
use Symfony\Base\Order\OrderReponse;

class GetOrderService {
    public function __construct(
        private OrderRepository $repository
    )
    {
    }

    public function __invoke(
        string $id
    ): OrderReponse
    {
        $order = $this->repository->find(new OrderId($id));

        if (null === $order) {
            throw new OrderNotFound();
        }

        return new OrderReponse(
            $order->id()->value(),
            $order->total()->value(),
            $order->items()->value()
        );
    }
}
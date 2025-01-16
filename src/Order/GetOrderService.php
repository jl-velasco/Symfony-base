<?php

namespace Symfony\Base\Order;

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
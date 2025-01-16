<?php

namespace Symfony\Base\Order;

class CreateOrderService
{
    public function __construct(private readonly OrderRepository $repository)
    {
    }

    public function __invoke(CreateOrderRequest $request): void
    {
        $order = new Order(
            new OrderId($request->id()),
            new OrderItems(),
            new OrderTotal(0)
        );

        $this->repository->save($order);
    }

}
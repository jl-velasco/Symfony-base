<?php

namespace Symfony\Base\Order;

class CreateOrderService
{
    public function __construct(
        private readonly OrderRepository $repository,
        private readonly OrderImageValidator $validator
    )
    {
    }

    public function __invoke(CreateOrderRequest $request): void
    {
        $order = new Order(
            new OrderId($request->id()),
            new OrderImage($request->image()),
            new OrderItems(),
            new OrderTotal(0)
        );

        $this->repository->save($order);
    }

}
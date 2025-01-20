<?php

namespace Symfony\Base\Order\Application;

use Symfony\Base\Order\Domain\OrderId;
use Symfony\Base\Order\Domain\OrderRepository;
use Symfony\Base\Order\OrderNotFound;
use Symfony\Base\Order\UpdateOrderRequest;

class UpdateOrderService
{
    public function __construct(private readonly OrderRepository $repository)
    {
    }

    public function __invoke(UpdateOrderRequest $request): void
    {

        $order = $this->repository->find(new OrderId($request->id()));

        if ($order === null) {
            throw new OrderNotFound();
        }

        $order->addItems($request->items());
        $order->updateTotal($request->total());

        $this->repository->save($order);
    }
}
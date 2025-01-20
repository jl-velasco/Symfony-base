<?php

namespace Symfony\Base\Order\Application;

use Symfony\Base\Order\CreateOrderRequest;
use Symfony\Base\Order\Domain\Order;
use Symfony\Base\Order\Domain\OrderId;
use Symfony\Base\Order\Domain\OrderImage;
use Symfony\Base\Order\Domain\OrderImageValidator;
use Symfony\Base\Order\Domain\OrderItems;
use Symfony\Base\Order\Domain\OrderRepository;
use Symfony\Base\Order\Domain\OrderTotal;

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
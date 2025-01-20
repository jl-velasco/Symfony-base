<?php

namespace Symfony\Base\Order\Application;

use Symfony\Base\Order\DeleteOrderRequest;
use Symfony\Base\Order\Domain\OrderId;
use Symfony\Base\Order\Domain\OrderRepository;
use Symfony\Base\Order\OrderNotFound;

class DeleteOrderService
{
    public function __construct(private readonly OrderRepository $repository)
    {
    }

    public function __invoke(DeleteOrderRequest $request): void
    {
        $order = $this->repository->search(new OrderId($request->id()));

        if ($order === null) {
            throw new OrderNotFound();
        }

        $this->repository->delete(new OrderId($request->id()));
    }
}
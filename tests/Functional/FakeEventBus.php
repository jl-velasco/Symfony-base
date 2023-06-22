<?php
declare(strict_types=1);

namespace Symfony\Base\Tests\Functional;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;

class FakeEventBus implements EventBus
{
    /** @var array<mixed, mixed> */
    protected array $message;

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->message[] = $event;
        }
    }
}

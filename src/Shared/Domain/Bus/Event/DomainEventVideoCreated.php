<?php
declare(strict_types = 1);
namespace Symfony\Base\Shared\Domain\Bus\Event;

interface DomainEventVideoCreated
{
    public function __invoke(DomainEvent $event):void;

    public static function videoCreatedTo(): array;

}

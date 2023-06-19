<?php
declare(strict_types = 1);
namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

interface DomainEventVideoDeleted
{
    public function __invoke(DomainEvent $event):void;

    public static function videoDeletedTo(): array;
}

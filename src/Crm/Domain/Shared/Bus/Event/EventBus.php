<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Domain\Shared\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent $domainEvent): void;
}

<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Shared\Domain\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent $domainEvent): void;
}

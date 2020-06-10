<?php

declare(strict_types = 1);

namespace Cuadrik\Shared\Domain\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents);//: void;
}

<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Domain\Shared\Bus\Event;

use Cuadrik\Crm\Infrastructure\Symfony\Bus\MessageHandler;

interface DomainEventSubscriber extends MessageHandler
{
    public static function subscribedTo(): array;
}

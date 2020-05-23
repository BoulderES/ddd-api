<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Shared\Domain\Bus\Event;

use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\MessageHandler;

interface DomainEventSubscriber extends MessageHandler
{
    public static function subscribedTo(): array;
}

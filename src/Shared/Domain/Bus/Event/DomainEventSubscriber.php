<?php

declare(strict_types = 1);

namespace Cuadrik\Shared\Domain\Bus\Event;


use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface DomainEventSubscriber extends MessageHandlerInterface
{
    public static function subscribedTo(): array;
}

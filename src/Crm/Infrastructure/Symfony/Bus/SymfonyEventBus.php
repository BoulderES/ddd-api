<?php


namespace Cuadrik\Crm\Infrastructure\Symfony\Bus;


use Cuadrik\Crm\Domain\Shared\Bus\Event\DomainEvent;
use Cuadrik\Crm\Domain\Shared\Bus\Event\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyEventBus implements EventBus
{

    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {

        $this->eventBus = $eventBus;

    }

    public function publish(DomainEvent ...$events): void
    {

        foreach ($events as $event) {

            $this->eventBus->dispatch($event);

        }

    }

}
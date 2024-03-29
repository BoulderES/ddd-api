<?php


namespace Cuadrik\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyEventBus implements EventBus
{

    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {

        $this->eventBus = $eventBus;

    }

    public function publish(DomainEvent ...$domainEvents): void
    {
//        $filesystem = new Filesystem();
//        $filesystem->appendToFile('/var/www/html/public/logs/SymfonyEventBus.log', '/var/www/html/logs/SymfonyEventBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        foreach($domainEvents as $domainEvent) {

            $this->eventBus->dispatch($domainEvent);

        }
//        $envelope = $this->eventBus->dispatch($domainEvent);
//
//        $handledStamp = $envelope->last(HandledStamp::class);
//        if(null !== $handledStamp)
//            return $handledStamp->getResult();
//
//        return $envelope;

    }

}
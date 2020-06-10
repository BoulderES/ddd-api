<?php


namespace Cuadrik\Shared\Domain\Bus\Event;


use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;

interface EventStore
{
    public function append(DomainEvent $domainEvent);
    public function allStoredEventsSince($eventId);
}
<?php


namespace Cuadrik\Crm\Shared\Domain\EventStore;


interface EventSourcedAggregateRoot
{
    public static function reconstitute(EventStream $events);
}
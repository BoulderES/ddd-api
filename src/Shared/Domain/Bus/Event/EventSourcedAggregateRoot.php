<?php


namespace Cuadrik\Shared\Domain\Bus\Event;


interface EventSourcedAggregateRoot
{
    public static function reconstitute(EventStream $events);
}
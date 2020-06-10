<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Bus\Event;


use BadMethodCallException;
use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Bus\Event\DomainEventSubscriber;

class DomainEventPublisher
{
    private $subscribers;

    private static $instance = null;

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new BadMethodCallException('Clone is not supported');
    }

    public function subscribe(
        DomainEventSubscriber $domainEventSubscriber
    ) {
        $this->subscribers[] = $domainEventSubscriber;
    }

    public function publish(DomainEvent $domainEvent)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }
}
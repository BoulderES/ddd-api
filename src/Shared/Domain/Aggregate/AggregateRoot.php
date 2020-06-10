<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Aggregate;

use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Bus\Event\DomainEventPublisher;
use Cuadrik\Shared\Domain\Bus\Event\EventStream;
use Cuadrik\Shared\Domain\Model\CommonData;

abstract class AggregateRoot  //extends CommonData
{
    private array $recordedEvents = [];

    final public function pullDomainEvents(): array
    {
        $recordedEvents       = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->recordedEvents[] = $domainEvent;
    }

    final public function popRecordedEvents(): array
    {
        $recordedEvents       = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }

    final protected function recordThat(DomainEvent $domainEvent): void
    {
        $this->recordedEvents[] = $domainEvent;
    }

    protected function applyThat(DomainEvent $domainEvent)
    {
        $class_parts = explode('\\', get_class($domainEvent));

        $modifier = 'apply' . end($class_parts);
        $this->$modifier($domainEvent);
    }

    protected function publishThat(DomainEvent $domainEvent)
    {
        DomainEventPublisher::instance()->publish($domainEvent);
    }

    public function recordedEvents()
    {
        return $this->recordedEvents;
    }

    public function clearEvents()
    {
        $this->recordedEvents = [];
    }

    protected function recordApplyAndPublishThat(
        DomainEvent $domainEvent
    ) {
        $this->recordThat($domainEvent);
        $this->applyThat($domainEvent);
        $this->publishThat($domainEvent);
    }

    public static function reconstitute(EventStream $events): self
    {
        $entity = new static($events->aggregateId());

        foreach ($events as $event) {
            var_export($event);
            $entity->applyThat($event);
        }

        return $entity;
    }

}

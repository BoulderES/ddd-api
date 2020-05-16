<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Aggregate;

use Cuadrik\Crm\Domain\Shared\Bus\Event\DomainEvent;
use Cuadrik\Crm\Domain\Shared\Model\CommonData;

abstract class AggregateRoot extends CommonData
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}

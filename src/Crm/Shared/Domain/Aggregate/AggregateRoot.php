<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Aggregate;

use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Crm\Shared\Domain\Model\CommonData;

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

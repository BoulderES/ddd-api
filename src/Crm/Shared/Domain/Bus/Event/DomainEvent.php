<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Shared\Domain\Bus\Event;

use Cuadrik\Crm\Shared\Domain\Utils\Utils;
use Cuadrik\Crm\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use JMS\Serializer\Annotation\Type;

abstract class DomainEvent
{
    /**
     * @var string
     * @Type("string")
     */
    private string $aggregateId;

    /**
     * @var string
     * @Type("string")
     */
    private string $eventId;

    /**
     * @var string
     * @Type("string")
     */
    private string $occurredOn;

    public function __construct(string $aggregateId)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId     = Uuid::random()->value();
        $this->occurredOn  = Utils::dateToString(new DateTimeImmutable());
    }

    abstract public function toPrimitives(): array;

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}

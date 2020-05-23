<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEvent;

final class UserCreatedDomainEvent extends DomainEvent
{
    private string $username;

    public function __construct(
        string $uuid,
        string $username,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);

        $this->username = $username;
    }

    public static function eventName(): string
    {
        return 'user.created';
    }

    public function toPrimitives(): array
    {
        return [
            'username'  => $this->username
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['username'], $eventId, $occurredOn);
    }

    public function username(): string
    {
        return $this->username;
    }
}

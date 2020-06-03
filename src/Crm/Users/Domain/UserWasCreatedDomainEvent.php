<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Domain;


use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;

final class UserWasCreatedDomainEvent extends DomainEvent
{
    private string $username;
    private string $companyId;

    public function __construct(
        string $uuid,
        string $username,
        string $companyId
    ) {
        parent::__construct($uuid);

        $this->username = $username;
        $this->companyId = $companyId;
    }

    public function __toString()
    {
        return "UserWasCreatedDomainEvent";
        // TODO: Implement __toString() method.
    }

    public static function eventName(): string
    {
        return 'user.created';
    }

    public function toPrimitives(): array
    {
        return [
            'username'  => $this->username,
            'companyId'  => $this->companyId
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['username'], $body['companyId'], $eventId, $occurredOn);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}

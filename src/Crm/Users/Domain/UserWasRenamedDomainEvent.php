<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Domain;


use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use JMS\Serializer\Annotation\Type;

final class UserWasRenamedDomainEvent extends DomainEvent
{

    /**
     * @var string
     * @Type("string")
     */
    private string $username;

    public function __construct(
        string $uuid,
        string $username
    ) {
        parent::__construct($uuid);

        $this->username = $username;
    }

    public function __toString()
    {
        return "UserWasRenamedDomainEvent";
        // TODO: Implement __toString() method.
    }

    public static function eventName(): string
    {
        return 'user.renamed';
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
        return new self($aggregateId, $body['username']);
    }

    public function username(): string
    {
        return $this->username;
    }

}

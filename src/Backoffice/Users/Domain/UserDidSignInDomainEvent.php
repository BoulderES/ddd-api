<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Model\CompanyId;
use JMS\Serializer\Annotation\Type;

final class UserDidSignInDomainEvent extends DomainEvent
{

    /**
     * @var string
     * @Type("string")
     */
    private string $username;

    /**
     * @var string
     * @Type("string")
     */
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
        return "UserDidSignInDomainEvent";
        // TODO: Implement __toString() method.
    }

    public static function eventName(): string
    {
        return 'user.signedUp';
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
        return new self($aggregateId, $body['username'], $body['companyId']);
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

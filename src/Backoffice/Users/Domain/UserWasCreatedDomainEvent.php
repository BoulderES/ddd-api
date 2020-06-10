<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Model\CompanyId;
use JMS\Serializer\Annotation\Type;

final class UserWasCreatedDomainEvent extends DomainEvent
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

    /**
     * @var string
     * @Type("string")
     */
    private string $password;

    /**
     * @var string
     * @Type("string")
     */
    private string $email;

    /**
     * @var string
     * @Type("string")
     */
    private string $token;

    /**
     * @var string
     * @Type("string")
     */
    private string $roles;

    /**
     * @var string
     * @Type("string")
     */
    private string $firstName;

    /**
     * @var string
     * @Type("string")
     */
    private string $lastName;

    /**
     * @var string
     * @Type("string")
     */
    private string $photoUrl;

    public function __construct(
        string $uuid,
        string $username,
        string $companyId,
        string $password,
        string $email,
        string $token,
        string $roles,
        string $firstName,
        string $lastName,
        string $photoUrl
    ) {
        parent::__construct($uuid);

        $this->username     = $username;
        $this->companyId    = $companyId;
        $this->password     = $password;
        $this->email        = $email;
        $this->token        = $token;
        $this->roles        = $roles;
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->photoUrl     = $photoUrl;
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
            'companyId' => $this->companyId,
            'password'  => $this->password,
            'email'     => $this->email,
            'token'     => $this->token,
            'roles'     => $this->roles,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'photoUrl'  => $this->photoUrl
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['username'],
            $body['companyId'],
            $body['password'],
            $body['email'],
            $body['token'],
            $body['roles'],
            $body['firstName'],
            $body['lastName'],
            $body['photoUrl']
        );
    }

    public function username(): string
    {
        return $this->username;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function roles(): string
    {
        return $this->roles;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function photoUrl(): string
    {
        return $this->photoUrl;
    }

}

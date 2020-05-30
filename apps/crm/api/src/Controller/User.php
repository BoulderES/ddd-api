<?php


namespace Cuadrik\Apps\Crm\Api\Controller;


use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Cuadrik\Crm\Companies\Domain\User\Roles;

final class User extends EventSourcedAggregateRoot
{
    /** @var string */
    private $id;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var Roles */
    private $role;

    /** @var string */
    private $username;

    /** @var string */
    private $passwordHash;

    public static function create(
        string $userId,
        string $username,
        string $passwordHash,
        string $firstName,
        string $lastName,
        Roles $role
    ): self {
        $user = new static();
        $user->apply(
            new UserWasCreatedEvent($userId, $username, $passwordHash, $firstName, $lastName, $role->getName())
        );

        return $user;
    }

    public static function instantiateForReconstitution(): self
    {
        return new static();
    }

    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    // … properties accessors

    protected function applyUserWasCreatedEvent(UserWasCreatedEvent $event): void
    {
        $this->id = $event->id;
        $this->firstName = $event->firstName;
        $this->lastName = $event->lastName;
        $this->role = new Roles($event->roleName);
    }
}

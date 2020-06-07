<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Infrastructure\Repository\EventSourcing;


use Cuadrik\Crm\Shared\Domain\EventStore\EventStream;
use Cuadrik\Crm\Shared\Infrastructure\Persistence\RedisEventStore;
use Cuadrik\Crm\Users\Domain\User;

class UserRepository
{
    private RedisEventStore $eventStore;

    public function __construct(RedisEventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(User $user): void
    {

        $this->eventStore->append(new EventStream($user->uuid()->value(), $user->pullDomainEvents()));

    }

    public function getEventsFor($id): User
    {
        $eventStream = $this->eventStore->getEventsFor($id);

        return User::reconstitute($eventStream);
    }

}
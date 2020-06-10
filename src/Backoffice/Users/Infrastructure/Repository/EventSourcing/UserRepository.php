<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Infrastructure\Repository\EventSourcing;


use Cuadrik\Shared\Domain\Bus\Event\EventStream;
use Cuadrik\Shared\Infrastructure\Persistence\RedisEventStore;
use Cuadrik\Backoffice\Users\Domain\User;

class UserRepository
{
    private RedisEventStore $eventStore;

    public function __construct(RedisEventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(User $user): void
    {

        $this->eventStore->appendEventStream(new EventStream($user->uuid()->value(), $user->pullDomainEvents()));

    }

    public function getEventsFor(string $id): User
    {

        $eventStream = $this->eventStore->getEventsFor($id);

        return User::reconstitute($eventStream);
    }

}
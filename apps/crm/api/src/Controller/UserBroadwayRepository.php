<?php


namespace Cuadrik\Apps\Crm\Api\Controller;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Cuadrik\Crm\Shared\Domain\Model\UserId;

final class UserBroadwayRepository implements UserRepository
{
    /** @var EventSourcingRepository */
    private $eventSourcingRepository;

    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        $this->eventSourcingRepository = new EventSourcingRepository(
            $eventStore,
            $eventBus,
            User::class,
            new NamedConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function get(UserId $userId): ?User
    {
        /** @var User $user */
        $user = $this->eventSourcingRepository->load($userId->get());

        return $user;
    }

    public function save(User $user): void
    {
        $this->eventSourcingRepository->save($user);
    }
}

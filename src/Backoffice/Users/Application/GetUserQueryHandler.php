<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Backoffice\Users\Domain\User;
use Cuadrik\Backoffice\Users\Domain\UserRepositoryInterface;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Backoffice\Users\Infrastructure\Repository\EventSourcing\UserRepository;

final class GetUserQueryHandler implements QueryHandler
{

    private UserRepositoryInterface $userRepository;
    private UserRepository          $userEventStoreRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserRepository          $userEventStoreRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userEventStoreRepository = $userEventStoreRepository;
    }

    public function __invoke(GetUserQuery $getUserQuery): void
    {
        $this->handle($getUserQuery);
    }

    public function handle(GetUserQuery $getUserQuery): User
    {
//        $user = $this->userRepository->userWithUuid($getUserQuery->getUuid());
        $user = $this->userEventStoreRepository->getEventsFor($getUserQuery->getUuid());

        if(!$user)
            ExceptionManager::throw('User not found! ' . get_called_class());

        return $user;

    }
}
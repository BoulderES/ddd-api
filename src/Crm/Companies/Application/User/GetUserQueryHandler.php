<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\User;

use Cuadrik\Crm\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Crm\Companies\Domain\User\User;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;

final class GetUserQueryHandler implements QueryHandler
{

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserQuery $getUserQuery): User
    {
        $user = $this->userRepository->userByUuid($getUserQuery->getUuid());

        if(!$user)
            ExceptionManager::throw('User not found! ' . get_called_class());

        return $user;

    }
}
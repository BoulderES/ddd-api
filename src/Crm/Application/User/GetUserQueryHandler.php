<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\User;

use Cuadrik\Crm\Domain\Shared\Bus\Query\QueryHandler;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\User\User;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;

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
            BadRequestException::throw('User not found! ' . get_called_class());

        return $user;

    }
}
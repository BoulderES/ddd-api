<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller;

use Broadway\CommandHandling\SimpleCommandHandler;
use Cuadrik\Crm\Companies\Domain\User\Roles;

final class CreateUserHandler extends SimpleCommandHandler
{

    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function handleCreateUserCommand(CreateUserCommand $createUserCommand): void
    {
        $user = User::create(
            $createUserCommand->userId,
            $createUserCommand->username,
            $createUserCommand->password,
            $createUserCommand->firstName,
            $createUserCommand->lastName,
            new Roles($createUserCommand->roleName)
        );
        $this->userRepository->save($user);

    }
}
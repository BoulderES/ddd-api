<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\Security;


use Cuadrik\Crm\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Crm\Companies\Domain\User\Password;
use Cuadrik\Crm\Companies\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Companies\Domain\User\Username;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;

class LoginQueryHandler implements QueryHandler
{

    private UserRepositoryInterface $userRepository;
    private PasswordEncoder $passwordEncoder;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordEncoder $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(LoginQuery $loginCommand): void
    {
        $this->handle($loginCommand);
    }

    public function handle(LoginQuery $loginCommand): UserId
    {
        $user = $this->userRepository->userByUsername($loginCommand->getUsername());
        if(!$user)
            ExceptionManager::throw('User not found! ' . get_called_class());

        if(!$this->passwordEncoder->isPasswordValid(
            $user->uuid(),
            $user->userName(),
            $user->password(),
            new Password($loginCommand->getPassword())
        ))
            ExceptionManager::throw('Wrong username/password! ' . get_called_class(), 401);


        return $user->uuid();

    }

}
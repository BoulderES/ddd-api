<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\Security;


use Cuadrik\Crm\Domain\Shared\Bus\Query\QueryHandler;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Domain\User\Username;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;

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

    public function __invoke(LoginQuery $loginCommand)
    {
        $user = $this->userRepository->findOneBy(['username.value' => $loginCommand->getUsername()]);
        if(!$user)
            ExceptionHandler::throw('User not found!', get_called_class());


        $username = new Username($loginCommand->getUsername());
        $hashedPassword = new Password($user->password()->value());
        $plainPassword = new Password($loginCommand->getPassword());


        if(!$this->passwordEncoder->isPasswordValid(
            $user->uuid(),
            $username,
            $hashedPassword,
            $plainPassword
        ))
            ExceptionHandler::throw('Wrong username/password!', get_called_class());


        return $user;

    }

}
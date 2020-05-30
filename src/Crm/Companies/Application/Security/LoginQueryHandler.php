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

    public function handle(LoginQuery $loginCommand)
    {
        $user = $this->userRepository->findOneBy(['username.value' => $loginCommand->getUsername()]);
        if(!$user)
            ExceptionManager::throw('User not found! ' . get_called_class());


        $uuid = new UserId($user->uuid());
        $username = new Username($loginCommand->getUsername());
        $hashedPassword = new Password($user->password());
        $plainPassword = new Password($loginCommand->getPassword());


        if(!$this->passwordEncoder->isPasswordValid(
            $uuid,
            $username,
            $hashedPassword,
            $plainPassword
        ))
            ExceptionManager::throw('Wrong username/password! ' . get_called_class(), 401);


        return $user;

    }

}
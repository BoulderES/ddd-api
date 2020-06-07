<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Application;


use Cuadrik\Crm\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\PasswordEncoder;
use Cuadrik\Crm\Users\Domain\Username;
use Cuadrik\Crm\Users\Domain\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Users\Infrastructure\Repository\EventSourcing\UserRepository;

class SignInQueryHandler implements QueryHandler
{

    private UserRepositoryInterface $userRepository;
    private PasswordEncoder $passwordEncoder;
    private UserRepository $userEventStoreRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordEncoder $passwordEncoder,
        UserRepository $userEventStoreRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userEventStoreRepository = $userEventStoreRepository;
    }

    public function __invoke(SignInQuery $signInQuery): void
    {
        $this->handle($signInQuery);
    }

    public function handle(SignInQuery $signInQuery): UserId
    {
        $user = $this->userRepository->userByUsername($signInQuery->getUsername());
        if(!$user)
            ExceptionManager::throw('User not found! ' . get_called_class());

        if(!$this->passwordEncoder->isPasswordValid(
            $user->uuid(),
            $user->userName(),
            $user->password(),
            new Password($signInQuery->getPassword())
        ))
            ExceptionManager::throw('Wrong username/password! ' . get_called_class(), 401);

        $user->doSignIn();

        $this->userEventStoreRepository->save($user);

        return $user->uuid();

    }

}
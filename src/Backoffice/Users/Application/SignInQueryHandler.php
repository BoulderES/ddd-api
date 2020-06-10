<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;


use Cuadrik\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Backoffice\Users\Domain\Password;
use Cuadrik\Backoffice\Users\Domain\PasswordEncoder;
use Cuadrik\Backoffice\Users\Domain\Username;
use Cuadrik\Backoffice\Users\Domain\UserRepositoryInterface;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Backoffice\Users\Infrastructure\Repository\EventSourcing\UserRepository;

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
        exit("llega");

        return $user->uuid();

    }

}
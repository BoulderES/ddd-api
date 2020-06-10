<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Backoffice\Companies\Application\CompanyBootstraping;
use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Backoffice\Users\Domain\FirstName;
use Cuadrik\Backoffice\Users\Domain\LastName;
use Cuadrik\Backoffice\Users\Domain\PhotoUrl;
use Cuadrik\Backoffice\Users\Domain\User;
use Cuadrik\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Backoffice\Users\Domain\TokenEncoderInterface;
use Cuadrik\Shared\Domain\Bus\Event\EventBus;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Backoffice\Users\Domain\Email;
use Cuadrik\Backoffice\Users\Domain\Password;
use Cuadrik\Backoffice\Users\Domain\PasswordEncoder;
use Cuadrik\Backoffice\Users\Domain\Roles;
use Cuadrik\Shared\Domain\Model\Token;
use Cuadrik\Backoffice\Users\Domain\Username;
use Cuadrik\Backoffice\Users\Domain\UserRepositoryInterface;
use Cuadrik\Backoffice\Users\Infrastructure\Repository\EventSourcing\UserRepository;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Symfony\Component\Filesystem\Filesystem;


final class CreateRegularUserCommandHandler implements CommandHandler
{

    private UserRepositoryInterface $userRepository;
    private CompanyBootstraping     $companyBootstraping;
    private PasswordEncoder         $passwordEncoder;
    private TokenEncoderInterface   $tokenEncoder;
    private EventBus                $bus;
    private UserRepository          $userEventStoreRepository;

    public function __construct( UserRepositoryInterface $userRepository, CompanyBootstraping $companyBootstraping, PasswordEncoder $passwordEncoder, TokenEncoderInterface $tokenEncoder, EventBus $bus, UserRepository $userEventStoreRepository )
    {
        $this->userRepository           = $userRepository;
        $this->companyBootstraping      = $companyBootstraping;
        $this->passwordEncoder          = $passwordEncoder;
        $this->tokenEncoder             = $tokenEncoder;
        $this->bus                      = $bus;
        $this->userEventStoreRepository = $userEventStoreRepository;
    }

    public function __invoke(CreateRegularUserCommand $createUserCommand): void
    {
        $this->handle($createUserCommand);
    }

    public function handle(CreateRegularUserCommand $createUserCommand): User
    {
        if("" === $createUserCommand->getPassword())
            ExceptionManager::throw('Password can not be empty. ' . get_called_class());

        if(null !== $this->userRepository->userWithUuid($createUserCommand->getUuid()))
            ExceptionManager::throw('User already exist. ' . get_called_class());

        $uuid       = new UserId($createUserCommand->getUuid());
        $username   = new Username($createUserCommand->getUsername());
        $email      = new Email($createUserCommand->getEmail());
        $password   = new Password( $this->passwordEncoder->encodePassword( $uuid, $username, new Password($createUserCommand->getPassword()) ) );
        $token      = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, new Password($createUserCommand->getPassword()), new Roles(Roles::REGULAR_USER_ROLE) ) );
        $roles      = new Roles(Roles::REGULAR_USER_ROLE);
        $companyId  = new CompanyId($createUserCommand->getCompanyUuid());
        $firstName  = new FirstName("");
        $lastName   = new LastName("");
        $photoUrl   = new PhotoUrl("");
//        $companyId  = new CompanyId('094b0f4d-5abe-44bb-813a-a8f84812b919');

        // TODO possible refactorization... (domain event implemented to create the related company)
//        $this->companyBootstraping->handle($companyId);

        $user = User::regularUserCreator( $uuid, $companyId, $username, $password, $email, $token, $roles, $firstName, $lastName, $photoUrl );
//        $this->userRepository->save($user);
        $this->userEventStoreRepository->save($user);

//        $filesystem = new Filesystem();
//        $filesystem->appendToFile('/var/www/html/public/logs/CreateRegularUserCommandHandler.log', '/var/www/html/logs/SymfonyEventBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        $this->bus->publish(...$user->pullDomainEvents());
        return $user;
    }

}
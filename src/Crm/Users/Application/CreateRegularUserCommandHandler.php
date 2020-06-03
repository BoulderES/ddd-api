<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Application;

use Cuadrik\Crm\Companies\Application\CompanyBootstraping;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Users\Domain\User;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Users\Domain\TokenEncoderInterface;
use Cuadrik\Crm\Shared\Domain\Bus\Event\EventBus;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Users\Domain\Email;
use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\PasswordEncoder;
use Cuadrik\Crm\Users\Domain\Roles;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Users\Domain\Username;
use Cuadrik\Crm\Users\Domain\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Symfony\Component\Filesystem\Filesystem;


final class CreateRegularUserCommandHandler implements CommandHandler
{

    private UserRepositoryInterface $userRepository;
    private CompanyBootstraping     $companyBootstraping;
    private PasswordEncoder         $passwordEncoder;
    private TokenEncoderInterface   $tokenEncoder;
    private EventBus                $bus;

    public function __construct( UserRepositoryInterface $userRepository, CompanyBootstraping $companyBootstraping, PasswordEncoder $passwordEncoder, TokenEncoderInterface $tokenEncoder, EventBus $bus )
    {
        $this->userRepository       = $userRepository;
        $this->companyBootstraping   = $companyBootstraping;
        $this->passwordEncoder      = $passwordEncoder;
        $this->tokenEncoder         = $tokenEncoder;
        $this->bus                  = $bus;
    }

    public function __invoke(CreateRegularUserCommand $createUserCommand): void
    {
        $this->handle($createUserCommand);
    }

    public function handle(CreateRegularUserCommand $createUserCommand): User
    {
        if("" === $createUserCommand->getPassword())
            ExceptionManager::throw('Password can not be empty. ' . get_called_class());

        if(null === $this->userRepository->userWithUuid($createUserCommand->getUuid()))
            ExceptionManager::throw('User already exist. ' . get_called_class());

        $uuid       = new UserId($createUserCommand->getUuid());
        $username   = new Username($createUserCommand->getUsername());
        $email      = new Email($createUserCommand->getEmail());
        $password   = new Password( $this->passwordEncoder->encodePassword( $uuid, $username, new Password($createUserCommand->getPassword()) ) );
        $token      = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, new Password($createUserCommand->getPassword()), new Roles(Roles::REGULAR_USER_ROLE) ) );
        $roles      = new Roles(Roles::REGULAR_USER_ROLE);
        $companyId  = new CompanyId($createUserCommand->getCompanyUuid());
//        $companyId  = new CompanyId('094b0f4d-5abe-44bb-813a-a8f84812b919');

        // TODO possible refactorization...
        $this->companyBootstraping->handle($companyId);

        $user = User::regularUserCreator( $uuid, $companyId, $username, $password, $email, $token, $roles );

        $this->userRepository->save($user);

        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/CreateRegularUserCommandHandler.log', '/var/www/html/logs/SymfonyEventBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        $this->bus->publish(...$user->pullDomainEvents());

        return $user;
    }

}
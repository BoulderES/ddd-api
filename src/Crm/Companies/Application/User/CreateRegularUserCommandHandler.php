<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\User;

use Cuadrik\Crm\Companies\Application\Company\CompanyGetOrCreate;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Companies\Domain\User\TokenEncoderInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Companies\Domain\User\Email;
use Cuadrik\Crm\Companies\Domain\User\Password;
use Cuadrik\Crm\Companies\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Companies\Domain\User\Roles;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Companies\Domain\User\Username;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Symfony\Component\Filesystem\Filesystem;


final class CreateRegularUserCommandHandler implements CommandHandler
{

    private UserRepositoryInterface $userRepository;
    private CreateRegularUser       $createRegularUser;
    private CompanyGetOrCreate      $companyGetOrCreate;
    private PasswordEncoder         $passwordEncoder;
    private TokenEncoderInterface   $tokenEncoder;

    public function __construct( UserRepositoryInterface $userRepository, CreateRegularUser $createRegularUser, CompanyGetOrCreate $companyGetOrCreate, PasswordEncoder $passwordEncoder, TokenEncoderInterface $tokenEncoder )
    {
        $this->userRepository       = $userRepository;
        $this->createRegularUser    = $createRegularUser;
        $this->companyGetOrCreate   = $companyGetOrCreate;
        $this->passwordEncoder      = $passwordEncoder;
        $this->tokenEncoder         = $tokenEncoder;
    }

    public function __invoke(CreateRegularUserCommand $createUserCommand): void
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/CreateRegularUserCommandHandler.log', '/var/www/html/logs/SymfonyEventBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        if("" === $createUserCommand->getPassword())
            ExceptionManager::throw('Password can not be empty. ' . get_called_class());

        $uuid       = new UserId($createUserCommand->getUuid());
        $username   = new Username($createUserCommand->getUsername());
        $email      = new Email($createUserCommand->getEmail());
        $password   = new Password( $this->passwordEncoder->encodePassword( $uuid, $username, new Password($createUserCommand->getPassword()) ) );
        $token      = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, new Password($createUserCommand->getPassword()), new Roles(Roles::REGULAR_USER_ROLE) ) );
        $roles      = new Roles(Roles::REGULAR_USER_ROLE);

        // TODO possible refactorization...
        $company    = $this->companyGetOrCreate->__invoke($createUserCommand->getCompanyUuid());


        $this->createRegularUser->__invoke($uuid,$company,$username,$password,$email,$token,$roles);

    }
}
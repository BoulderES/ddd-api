<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\User;

use Cuadrik\Crm\Application\Company\CompanyGetOrCreate;
use Cuadrik\Crm\Domain\Shared\Bus\Command\CommandHandler;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\Service\TokenEncoderInterface;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\User\Email;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Domain\User\Roles;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\User\Username;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;
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
            BadRequestException::throw('Password can not be empty. ' . get_called_class());

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
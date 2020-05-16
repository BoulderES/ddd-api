<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\User;

use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Domain\Shared\Bus\Command\CommandHandler;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\Shared\Service\TokenEncoderInterface;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\User\Email;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Domain\User\Roles;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\User\User;
use Cuadrik\Crm\Domain\User\Username;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;


final class CreateRegularUserCommandHandler implements CommandHandler
{

    private UserRepositoryInterface $userRepository;
    private CompanyRepositoryInterface $companyRepository;
    private PasswordEncoder $passwordEncoder;
    private TokenEncoderInterface $tokenEncoder;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CompanyRepositoryInterface $companyRepository,
        PasswordEncoder $passwordEncoder,
        TokenEncoderInterface $tokenEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenEncoder = $tokenEncoder;
    }

    public function __invoke(CreateRegularUserCommand $createUserCommand): User
    {

        if("" === $createUserCommand->getPassword())
            ExceptionHandler::throw('Password can not be empty.', get_called_class());

        $company = $this->companyRepository->findOneBy(['uuid.value' => $createUserCommand->getCompanyUuid()]);

        if(null === $company) {

            $company = Company::create(
                new CompanyId($createUserCommand->getCompanyUuid()),
                new IsMain(true)
            );

        }

        $uuid = new UserId($createUserCommand->getUuid());
        $username = new Username($createUserCommand->getUsername());
        $email = new Email($createUserCommand->getEmail());

        $hashed_password = new Password( $this->passwordEncoder->encodePassword( $uuid, $username, new Password($createUserCommand->getPassword()) ) );

        $token = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, new Password($createUserCommand->getPassword()), new Roles(Roles::REGULAR_USER_ROLE) ) );

        $user = User::regularUserCreator(
            $uuid,
            $company,
            $username,
            $hashed_password,
            $email,
            $token,
            new Roles(Roles::REGULAR_USER_ROLE)
        );

        $this->userRepository->save($user);

        return $user;

        //        $filesystem = new Filesystem();
//        $filesystem->appendToFile('/var/www/html/public/logs/CreateRegularUserCommandHandler.log', '/var/www/html/logs/CreateRegularUserCommandHandler'.date("Y-m-d H:i:s")."\n".$hashed_password->value()."\n"."\n"."\n"."\n"."\n");

//        $this->userRepository->save($user);

//        return [
//            'token' => $user->token(),
//            'user' => UserMakeup::execute($user)
//        ];

    }
}
<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\User;

use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Domain\Shared\Bus\Command\CommandHandler;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\Service\TokenEncoderInterface;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\User\Email;
use Cuadrik\Crm\Domain\User\FirstName;
use Cuadrik\Crm\Domain\User\LastName;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Domain\User\PhotoUrl;
use Cuadrik\Crm\Domain\User\Roles;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\User\User;
use Cuadrik\Crm\Domain\User\Username;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;


final class UpdateUserCommandHandler implements CommandHandler
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

    public function __invoke(UpdateUserCommand $updateUserCommand): User
    {
        $user = $this->userRepository->userByUuid($updateUserCommand->getUuid());

        if(!$user)
            BadRequestException::throw('User not found! ' . get_called_class());


        $uuid = new UserId($updateUserCommand->getUuid());
        $username = new Username($updateUserCommand->getUsername());
        $email = new Email($updateUserCommand->getEmail());
        $photoUrl = new PhotoUrl($updateUserCommand->getPhotoUrl());
        $firstName = new FirstName($updateUserCommand->getFirstName());
        $lastName = new LastName($updateUserCommand->getLastName());


        $hashed_password = "";
        if("" !== $updateUserCommand->getPassword())
            $hashed_password = new Password( $this->passwordEncoder->encodePassword( $uuid, $username, new Password($updateUserCommand->getPassword()) ) );


        $user = User::update(
            $username,
            $hashed_password,
            $email,
            $photoUrl,
            $firstName,
            $lastName
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
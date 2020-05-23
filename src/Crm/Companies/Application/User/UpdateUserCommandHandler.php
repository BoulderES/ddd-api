<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\User;

use Cuadrik\Crm\Companies\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Companies\Domain\User\TokenEncoderInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Companies\Domain\User\Email;
use Cuadrik\Crm\Companies\Domain\User\FirstName;
use Cuadrik\Crm\Companies\Domain\User\LastName;
use Cuadrik\Crm\Companies\Domain\User\Password;
use Cuadrik\Crm\Companies\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Companies\Domain\User\PhotoUrl;
use Cuadrik\Crm\Companies\Domain\User\User;
use Cuadrik\Crm\Companies\Domain\User\Username;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;


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
            ExceptionManager::throw('User not found! ' . get_called_class());


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
//            'user' => SPAUserProjector::execute($user)
//        ];

    }
}
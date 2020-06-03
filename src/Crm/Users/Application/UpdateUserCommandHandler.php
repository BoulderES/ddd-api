<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Application;

use Cuadrik\Crm\Companies\Domain\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Users\Domain\TokenEncoderInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Users\Domain\Email;
use Cuadrik\Crm\Users\Domain\FirstName;
use Cuadrik\Crm\Users\Domain\LastName;
use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\PasswordEncoder;
use Cuadrik\Crm\Users\Domain\PhotoUrl;
use Cuadrik\Crm\Users\Domain\User;
use Cuadrik\Crm\Users\Domain\Username;
use Cuadrik\Crm\Users\Domain\UserRepositoryInterface;
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

    public function __invoke(UpdateUserCommand $updateUserCommand): void
    {
        $this->handle($updateUserCommand);
    }

    public function handle(UpdateUserCommand $updateUserCommand): User
    {
        $user = $this->userRepository->userWithUuid($updateUserCommand->getUuid());

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
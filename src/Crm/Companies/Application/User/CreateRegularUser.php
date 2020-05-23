<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\User;

use Cuadrik\Crm\Companies\Domain\Company\Company;
use Cuadrik\Crm\Shared\Domain\Bus\Event\EventBus;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Companies\Domain\User\Email;
use Cuadrik\Crm\Companies\Domain\User\Password;
use Cuadrik\Crm\Companies\Domain\User\Roles;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Companies\Domain\User\User;
use Cuadrik\Crm\Companies\Domain\User\Username;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;


final class CreateRegularUser
{

    private UserRepositoryInterface $userRepository;
    private EventBus                $bus;

    public function __construct( UserRepositoryInterface $userRepository, EventBus $bus)
    {
        $this->userRepository   = $userRepository;
        $this->bus              = $bus;
    }

    public function __invoke( UserId $uuid, Company $company, Username $username, Password $password, Email $email, Token $token, Roles $roles ): void
    {

        $user = User::regularUserCreator( $uuid, $company, $username, $password, $email, $token, $roles );

        $this->userRepository->save($user);

        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/CreateRegularUser.log', '/var/www/html/logs/SymfonyEventBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        $this->bus->publish(...$user->pullDomainEvents());

    }
}
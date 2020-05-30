<?php


namespace Cuadrik\Crm\Companies\Application\User;


use Cuadrik\Crm\Companies\Domain\User\UserCreatedDomainEvent;
use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Cuadrik\Crm\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Filesystem\Filesystem;

class UserCreatedDomainEventHandler implements DomainEventSubscriber
{

    public function __invoke(UserCreatedDomainEvent $userCreatedDomainEvent)
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/UserCreatedDomainEventHandler.log', date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n". $userCreatedDomainEvent);


        // TODO: Implement __invoke() method.
    }

    /**
     * @return array
     */
    public static function subscribedTo(): array
    {
        // TODO: Implement subscribedTo() method.
    }
}
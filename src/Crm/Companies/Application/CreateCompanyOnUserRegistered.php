<?php


namespace Cuadrik\Crm\Companies\Application;


use Cuadrik\Crm\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Users\Domain\UserWasCreatedDomainEvent;
use Symfony\Component\Filesystem\Filesystem;

class CreateCompanyOnUserRegistered implements DomainEventSubscriber
{
    private CompanyBootstraping $creator;

    public function __construct(CompanyBootstraping $creator)
    {
        $this->creator = $creator;
    }

    public static function subscribedTo(): array
    {
        return [UserWasCreatedDomainEvent::class];
    }

    public function __invoke(UserWasCreatedDomainEvent $event): void
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/CreateCompanyOnUserRegistered.log',  ' - '.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        $companyId  = new CompanyId($event->companyId());

        $this->creator->handle($companyId);
    }

}
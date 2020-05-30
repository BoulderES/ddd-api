<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Crm\Shared\Domain\Bus\Command\SyncCommand;
use Cuadrik\Crm\Shared\Domain\Bus\Command\SyncCommandBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonySyncCommandBus implements SyncCommandBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {

        $this->messageBus = $queryBus;

    }

    public function handle(SyncCommand $command, array $stamps = [])//: void
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/SymfonyCommandBus.log', '/var/www/html/logs/MessageBusInterface'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        return $this->handle($command);

    }
}
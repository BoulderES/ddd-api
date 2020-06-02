<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Crm\Shared\Domain\Bus\Command\Command;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyCommandBus implements CommandBus
{

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {

        $this->commandBus = $commandBus;

    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

}
<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Shared\Domain\Bus\Command\AsyncCommand as Command;
use Cuadrik\Shared\Domain\Bus\Command\AsyncCommandBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyAsyncCommandBus implements AsyncCommandBus
{

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {

        $this->commandBus = $commandBus;

    }

    public function dispatchAsync(Command $command)
    {
        $this->commandBus->dispatch($command);
    }

}
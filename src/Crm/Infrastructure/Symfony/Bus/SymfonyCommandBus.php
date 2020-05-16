<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Infrastructure\Symfony\Bus;


use Cuadrik\Crm\Domain\Shared\Bus\Command\Command;
use Cuadrik\Crm\Domain\Shared\Bus\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyCommandBus implements CommandBus
{

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {

        $this->commandBus = $commandBus;

    }

    public function dispatch(Command $command, array $stamps = [])
    {

        $envelope = $this->commandBus->dispatch($command);

        $handledStamp = $envelope->last(HandledStamp::class);
        if(null !== $handledStamp)
            return $handledStamp->getResult();

        return $envelope;

    }
}
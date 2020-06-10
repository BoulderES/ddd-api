<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Shared\Domain\Bus\Command\SyncCommand as Command;
use Cuadrik\Shared\Domain\Bus\Command\SyncCommandBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonySyncCommandBus implements SyncCommandBus
{

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {

        $this->commandBus = $commandBus;

    }

    public function dispatchSync(Command $command)
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/SymfonySyncCommandBus.log', '/var/www/html/logs/MessageBusInterface'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");

        try {
            /** @var HandledStamp $stamp */

            $stamp = $this->commandBus->dispatch($command)->last(HandledStamp::class);
            return $stamp->getResult();
        } catch (\Exception $unused) {
            throw new \Exception($unused->getMessage());
        }
    }

}
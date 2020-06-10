<?php


namespace Cuadrik\Shared\Infrastructure\Symfony;


use Cuadrik\Shared\Domain\Bus\Command\Command;
use Cuadrik\Shared\Domain\Bus\Command\SyncCommand;
use Cuadrik\Shared\Domain\Bus\Command\CommandBus;
use Cuadrik\Shared\Domain\Bus\Command\SyncCommandBus;
use Cuadrik\Shared\Domain\Bus\Query\Query;
use Cuadrik\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ExtendedController extends AbstractController
{
    private QueryBus        $queryBus;
    private CommandBus      $commandBus;
    private SyncCommandBus  $syncCommandBus;

    public function __construct(
        QueryBus        $queryBus,
        CommandBus      $commandBus,
        SyncCommandBus  $syncCommandBus
    )
    {
        $this->queryBus         = $queryBus;
        $this->commandBus       = $commandBus;
        $this->syncCommandBus   = $syncCommandBus;
    }

    protected function query(Query $query)
    {
        return $this->queryBus->query($query);
    }

    protected function dispatchSync(SyncCommand $command)
    {
        return $this->syncCommandBus->dispatchSync($command);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
<?php


namespace Cuadrik\Crm\Shared\Infrastructure\Symfony;


use Cuadrik\Crm\Shared\Domain\Bus\Command\Command;
use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandBus;
use Cuadrik\Crm\Shared\Domain\Bus\Command\SyncCommand;
use Cuadrik\Crm\Shared\Domain\Bus\Command\SyncCommandBus;
use Cuadrik\Crm\Shared\Domain\Bus\Query\Query;
use Cuadrik\Crm\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
        $this->queryBus     = $queryBus;
        $this->commandBus   = $commandBus;
        $this->syncCommandBus   = $syncCommandBus;
    }

    protected function query(Query $query): ?Response
    {
        return $this->queryBus->query($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function handle(SyncCommand $command): void
    {
        $this->syncCommandBus->handle($command);
    }

}
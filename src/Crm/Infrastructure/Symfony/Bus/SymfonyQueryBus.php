<?php


namespace Cuadrik\Crm\Infrastructure\Symfony\Bus;


use Cuadrik\Crm\Domain\Shared\Bus\Query\Query;
use Cuadrik\Crm\Domain\Shared\Bus\Query\QueryBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param Query $query
     *
     * @return mixed The handler returned value
     */
    public function query(Query $query)//: ?Response
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile('/var/www/html/public/logs/SymfonyQueryBus.log', '/var/www/html/logs/SymfonyQueryBus'.date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n"."\n"."\n");
        return $this->handle($query);
    }

}
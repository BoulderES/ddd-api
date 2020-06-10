<?php


namespace Cuadrik\Shared\Infrastructure\Symfony\Bus;


use Cuadrik\Shared\Domain\Bus\Query\Query;
use Cuadrik\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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
//        return $this->handle($query);
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->messageBus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (\Exception $unused) {
            throw new \Exception($query);
        }

    }

}
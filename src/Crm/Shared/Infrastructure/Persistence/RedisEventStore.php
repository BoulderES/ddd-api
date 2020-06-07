<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Infrastructure\Persistence;


use Cuadrik\Crm\Shared\Domain\EventStore\EventStream;
use DateTimeImmutable;
use JMS\Serializer\SerializerInterface;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

class RedisEventStore
{
    private ClientInterface $redis;
    private SerializerInterface $serializer;

    public function __construct(ClientInterface $redis, SerializerInterface $serializer)
    {
        $this->redis = $redis;
        $this->serializer = $serializer;
    }

    public function append(EventStream $eventstream)
    {
        foreach ($eventstream as $event) {
            $data = $this->serializer->serialize(
                $event, 'json'
            );
            $date = (new DateTimeImmutable())->format('YmdHis');
            $this->redis->rpush(
                'events:' . $event->aggregateId(),
                (array)$this->serializer->serialize([
                    'type' => get_class($event),
                    'created_on' => $date,
                    'data' => $data
                ], 'json')
            );
        }
    }

    public function getEventsFor($id)
    {
        $serializedEvents = $this->redis->lrange('events:' . $id, 0, -1);
        $eventStream = [];
        foreach($serializedEvents as $serializedEvent){
            $eventData = $this->serializerdeserialize(
                $serializedEvent,
                'array',
                'json'
                );
                $eventStream[] = $this->serializer->deserialize(
                    $eventData['data'],
                    $eventData['type'],
                    'json'
                );
            }
        return new EventStream($id, $eventStream);
    }

}
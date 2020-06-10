<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Infrastructure\Persistence;


use Cuadrik\Shared\Domain\Bus\Event\DomainEvent;
use Cuadrik\Shared\Domain\Bus\Event\EventStream;
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

    public function append(DomainEvent $event)
    {
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

    public function appendEventStream(EventStream $eventstream)
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
            $eventData = $this->serializer->deserialize(
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

    public function byId($id)
    {
        $key = 'snapshots:' . $id;
        $metadata = $this->serializer->unserialize(
            $this->redis->get($key)
        );
        if (null === $metadata) {
            return;
        }
        return new Snapshot(
            $metadata['version'],
            $this->serializer->unserialize(
                $metadata['snapshot']['data'],
                $metadata['snapshot']['type'],
                'json'
            )
        );
    }

    public function save($id, Snapshot $snapshot)
    {
        $key = 'snapshots:' . $id;
        $aggregate = $snapshot->aggregate();
        $snapshot = [
            'version' => $snapshot->version(),
            'snapshot' => [
                'type' => get_class($aggregate),
                'data' => $this->serializer->serialize(
                    $aggregate, 'json'
                )
            ]
        ];
        $this->redis->set($key, $snapshot);
    }
}
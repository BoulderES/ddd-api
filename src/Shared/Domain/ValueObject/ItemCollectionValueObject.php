<?php


namespace Cuadrik\Shared\Domain\ValueObject;


use SplObjectStorage;

class ItemCollectionValueObject
{

    private SplObjectStorage $collection;

    public function __construct(array $items)
    {
        foreach ($items as $item){
            $this->collection->attach($item);
        }
    }

    public function add($item)
    {
        $this->collection->attach($item);

        return $this;
    }

    public function remove($item)
    {
        $this->collection->detach($item);

        return $this;
    }

    public function clean()
    {
        $this->collection->removeAll($this->collection);
    }
}
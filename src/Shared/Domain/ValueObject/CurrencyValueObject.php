<?php


namespace Cuadrik\Shared\Domain\ValueObject;


class CurrencyValueObject
{

    private string $sort;
    private string $long;

    public function __construct(string $sort, string $long = "")
    {
        $this->sort = $sort;
        $this->long = $long;
    }

    public function sort()
    {
        return $this->sort;
    }

    public function long()
    {
        return $this->long;
    }
}
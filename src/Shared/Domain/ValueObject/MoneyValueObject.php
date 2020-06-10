<?php


namespace Cuadrik\Shared\Domain\ValueObject;


class MoneyValueObject
{
    private float $amount;

    private CurrencyValueObject $currency;

    public function __construct(float $amount, CurrencyValueObject $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount($decimal = 2)
    {

        return round($this->amount, $decimal);
    }

    public function currency()
    {
        return $this->currency;
    }

    public function __toString()
    {
        return $this->amount . " " . $this->currency->sort();
        // TODO: Implement __toString() method.
    }
}
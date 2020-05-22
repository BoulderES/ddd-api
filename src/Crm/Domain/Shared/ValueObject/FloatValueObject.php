<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Domain\Shared\ValueObject;


abstract class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public static function fromFloat(float $value): self
    {
        return new static($value);
    }
}
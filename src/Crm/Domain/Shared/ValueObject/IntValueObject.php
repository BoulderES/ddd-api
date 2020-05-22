<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Domain\Shared\ValueObject;


abstract class IntValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }


    public static function fromInt(int $value): self
    {
        return new static($value);
    }
}
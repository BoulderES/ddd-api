<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Shared\Domain\ValueObject;


abstract class BooleanValueObject
{
    protected bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function asBool(): bool
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public static function fromBool(bool $value): self
    {
        return new static($value);
    }
}

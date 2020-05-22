<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Domain\Shared\ValueObject;


abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }
}

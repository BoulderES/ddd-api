<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Domain\Shared\ValueObject;


use DateTimeImmutable;
use DateTimeInterface;

abstract class DateTimeValueObject
{
    protected DateTimeImmutable $value;

    public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value()->format(DateTimeInterface::ATOM);
    }

    public function asString(): string
    {
        return $this->value()->format(DateTimeInterface::ATOM);
    }


    public static function fromString(string $value): self
    {
        return new static(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $value));
    }
}
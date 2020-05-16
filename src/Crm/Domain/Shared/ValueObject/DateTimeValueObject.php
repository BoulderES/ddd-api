<?php
declare(strict_types=1);


namespace Cuadrik\Crm\Domain\Shared\ValueObject;


abstract class DateTimeValueObject
{
    protected \DateTime $value;

    public function __construct(\DateTime $value)
    {
        $this->value = $value;
    }

    public function value(): \DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value()->format("Y-m-d H:i:s");
    }
}
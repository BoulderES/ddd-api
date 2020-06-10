<?php

declare(strict_types = 1);

namespace Cuadrik\Shared\Domain\Utils;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;

final class DateToString
{
    public static function do(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

}

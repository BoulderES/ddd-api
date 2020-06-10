<?php

declare(strict_types = 1);

namespace Cuadrik\Shared\Domain\Utils;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;

final class StringToDate
{
    public static function do(string $date): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($date);
        } catch (\Exception $e) {
            throw new RuntimeException('Unable to parse string to date ' . $e->getMessage());
        }
    }

}

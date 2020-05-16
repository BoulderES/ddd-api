<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared;

use RuntimeException;

class ExceptionHandler
{
    public static function throw($message, $debug)
    {

        throw new RuntimeException($message. " - " . $debug);

    }

}
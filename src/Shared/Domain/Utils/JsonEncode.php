<?php


namespace Cuadrik\Shared\Domain\Utils;


use RuntimeException;

class JsonEncode
{

    public static function execute(array $values): string
    {
        return json_encode($values);
    }

}
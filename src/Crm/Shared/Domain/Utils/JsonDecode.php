<?php


namespace Cuadrik\Crm\Shared\Domain\Utils;


use RuntimeException;

class JsonDecode
{

    public static function execute(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data;
    }

}
<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory;

class ExceptionFactory
{
    public function response(String $responseType, String $message = "")
    {
        $className = "Cuadrik\\Crm\\Infrastructure\\Symfony\\Service\\ExceptionFactory\\" . ucfirst($responseType)."Exception";

        if( ! class_exists($className)) {
            throw new \RuntimeException('Class ' . $className . ' doesn\'t exist');
        }

        if(!is_string($message))
            $message = serialize($message);

        return $className::execute($message);
    }
}
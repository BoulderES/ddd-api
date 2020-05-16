<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory;

use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\HttpException;

class UnauthorizedException
{
    public static function throw($message)
    {
        throw new HttpException(401, "Unauthorized access. " . $message);
    }
}
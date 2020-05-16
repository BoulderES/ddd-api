<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory;

use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\BadRequestHttpException;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\HttpException;

class BadRequestException
{
    public static function throw($message)
    {
        throw new HttpException(400, "Invalid data. " . $message);
        throw new BadRequestHttpException( "Invalid data! " . $message);
    }
}
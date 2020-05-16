<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory;

use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\NotFoundHttpException;

class NotFoundException
{
    public static function throw($message)
    {
        throw new NotFoundHttpException( "Not found! " . $message);
    }
}
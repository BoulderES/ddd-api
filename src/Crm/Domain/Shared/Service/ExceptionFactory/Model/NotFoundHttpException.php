<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model;

use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\HttpException;

class NotFoundHttpException extends HttpException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Throwable $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct(string $message = null, \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(404, $message, $previous, $headers, $code);
    }
}

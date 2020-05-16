<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Infrastructure\Symfony\EventListener;

use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\Model\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class ExceptionListener
{

    public function onException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if($exception instanceof HandlerFailedException){
            $exception = $exception->getNestedExceptions()[0];
        }
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent($message);

//        if ($exception instanceof HttpException) {

            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
//        } else {
//            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

        $event->setResponse($response);
    }
}

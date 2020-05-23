<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Infrastructure\Symfony\EventListener;

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

        if(
            method_exists($exception, "getStatusCode")
            && method_exists($exception, "getHeaders")
        ){
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }

        $event->setResponse($response);
    }
}

<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Infrastructure\Symfony\EventListener;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class ExceptionListener
{

    public function onException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if($exception instanceof HandlerFailedException){
            $exception = $exception->getNestedExceptions()[0];
        }

        $this->exceptionStackToFile($exception);

        $message = sprintf(
            'Error type: %s with code: %s',
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

    public function exceptionStackToFile($exception)
    {

        $filesystem = new Filesystem();
        $filesystem->remove('/var/www/html/public/logs/Exception.log');
        $filesystem->appendToFile('/var/www/html/public/logs/Exception.log', date("Y-m-d H:i:s")."\n".date("Y-m-d H:i:s")."\n"."\n"."\n". $exception);

    }
}

<?php


namespace Cuadrik\Crm\Infrastructure\Symfony\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;


class JWTCreatedListener
{

    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();
        $request = $this->requestStack->getCurrentRequest();


        // Add the client ip in the user token
        $payload       = $event->getData();
        $payload['uuid'] = $user->getUuid();

        if($request)
            $payload['ip'] = $request->getClientIp();

        $event->setData($payload);

//        $header        = $event->getHeader();
//        $header['cty'] = 'JWT';
//        $event->setHeader($header);

    }

}
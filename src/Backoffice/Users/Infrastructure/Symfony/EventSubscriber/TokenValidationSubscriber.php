<?php

declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Infrastructure\Symfony\EventSubscriber;


use Cuadrik\Shared\Domain\Model\Token;
use Cuadrik\Backoffice\Users\Domain\TokenDecoderInterface;
use Cuadrik\Backoffice\Users\Domain\UserRepositoryInterface;
use Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenValidationSubscriber implements EventSubscriberInterface
{

    private UserRepositoryInterface $userRepository;

    private TokenDecoderInterface $tokenDecoder;

    public function __construct(UserRepositoryInterface $userRepository, TokenDecoderInterface $tokenDecoder)
    {
        $this->userRepository = $userRepository;
        $this->tokenDecoder = $tokenDecoder;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {

            $request = $this->cleanTokenInjections($event->getRequest());

            if($this->needAuth($request->getPathInfo())){

                $token = $this->extractToken($request);

                if (!$this->userRepository->userUuidByToken($token))
                    ExceptionManager::throw('User related to the token not found!', 401);

            }

        }

    }

    private function extractToken(Request $request): string
    {
        $token = $this->tokenDecoder->decode(substr($request->headers->get('Authorization'), 7));

        $request->request->set('token', $token);

        return $token->value();
    }


    private function needAuth(string $pathInfo): bool
    {
        return false;
//        return "/api/auth/" === substr( $pathInfo, 0, 10 );
    }

    private function cleanTokenInjections($request)
    {
        if($request->request->has('token'))
            $request->request->remove('token');

        return $request;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
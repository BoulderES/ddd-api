<?php


namespace Cuadrik\Crm\Infrastructure\Symfony\EventSubscriber;


use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\Shared\Service\TokenDecoderInterface;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {

            $request = $this->cleanTokenInjections($event->getRequest());

            if($this->needAuth($request->getPathInfo())){

                $token = $this->extractToken($request);

                $user = $this->userRepository->userIdByToken($token->value());

                if (!$user)
                    throw new AccessDeniedHttpException('User related to the token not found!');

            }

        }

    }

    private function extractToken(Request $request): Token
    {
        $token = $this->tokenDecoder->decode(substr($request->headers->get('Authorization'), 7));

        $request->request->set('token', $token);

        return $token;
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
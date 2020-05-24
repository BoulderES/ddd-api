<?php


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\Security\RefreshTokenCommand;
use Cuadrik\Crm\Companies\Application\Security\RefreshTokenCommandHandler;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Crm\Companies\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class RefreshTokenController extends AbstractController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/refresh-token", defaults={}, name="validation")
     * @param Request $request
     * @param RefreshTokenCommandHandler $refreshTokenCommandHandler
     * @param SymfonyCommandBus $bus
     * @return string the token validation return a new token with a fresh expiration date
     */
    public function refreshToken(Request $request, RefreshTokenCommandHandler $refreshTokenCommandHandler, SymfonyCommandBus $bus)
    {
        $token = $request->request->get("token");

        $refreshTokenCommandHandler->__invoke(new RefreshTokenCommand(
                $token
            )
        );

        return $this->redirectToRoute('view_user', ['uuid' => $token->uuid()]);
    }

}
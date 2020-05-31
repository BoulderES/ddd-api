<?php


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\Security\RefreshTokenCommand;
use Cuadrik\Crm\Companies\Application\Security\RefreshTokenCommandHandler;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Crm\Companies\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class RefreshTokenController extends ExtendedController  implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/refresh-token", defaults={}, name="validation")
     * @param Request $request
     * @param RefreshTokenCommandHandler $refreshTokenCommandHandler
     * @return string the token validation return a new token with a fresh expiration date
     */
    public function refreshToken(Request $request, RefreshTokenCommandHandler $refreshTokenCommandHandler)
    {

        $uuid = $refreshTokenCommandHandler->handle(new RefreshTokenCommand(
                $request->request->get("token")
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $uuid->value()]);
    }

}
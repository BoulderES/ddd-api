<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Backoffice\Api\Controller\Security;


use Cuadrik\Backoffice\Users\Application\RefreshTokenCommand;
use Cuadrik\Backoffice\Users\Application\RefreshTokenCommandHandler;
use Cuadrik\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class RefreshTokenController extends ExtendedController  implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/refresh-token", defaults={}, name="validation")
     * @param Request $request
     * @param RefreshTokenCommandHandler $refreshTokenCommandHandler
     * @return RedirectResponse
     */
    public function refreshToken(Request $request, RefreshTokenCommandHandler $refreshTokenCommandHandler): RedirectResponse
    {

        $uuid = $refreshTokenCommandHandler->handle(new RefreshTokenCommand(
                $request->request->get("token")
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $uuid->value()]);
    }

}
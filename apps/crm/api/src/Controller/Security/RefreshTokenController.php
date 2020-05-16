<?php


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Application\Security\RefreshTokenCommand;
use Cuadrik\Crm\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Crm\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class RefreshTokenController extends AbstractController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/refresh-token", defaults={}, name="validation")
     * @param Request $request
     * @param SymfonyCommandBus $bus
     * @return string the token validation return a new token with a fresh expiration date
     */
    public function refreshToken(Request $request, SymfonyCommandBus $bus)
    {
        $token = $request->request->get("token");

        $bus->dispatch(new RefreshTokenCommand(
                $token
            )
        );

        return $this->redirectToRoute('view_user', ['uuid' => $token->uuid()]);
    }

}
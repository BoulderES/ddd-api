<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\Security\LoginQuery;
use Cuadrik\Crm\Companies\Application\Security\LoginQueryHandler;
use Cuadrik\Crm\Companies\Infrastructure\Projections\SPAUserProjector;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends ExtendedController
{
    /**
     * @Route("/api/login", defaults={}, name="login")
     * @param Request $request
     * @param LoginQueryHandler $loginQueryHandler
     * @return string
     */
    public function index(Request $request, LoginQueryHandler $loginQueryHandler)
    {

        $user = $loginQueryHandler->handle(new LoginQuery(
                $request->request->get("username"),
                $request->request->get("password")
            )
        );

        return new JsonResponse(
            [
                'token' => $user->token(),
                'user' => SPAUserProjector::execute($user)
            ]

        );
    }

}
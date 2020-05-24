<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\Security\LoginQuery;
use Cuadrik\Crm\Companies\Application\Security\LoginQueryHandler;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Crm\Companies\Infrastructure\Projections\SPAUserProjector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", defaults={}, name="login")
     * @param Request $request
     * @param LoginQueryHandler $loginQueryHandler
     * @param SymfonyQueryBus $bus
     * @return string
     */
    public function index(Request $request, LoginQueryHandler $loginQueryHandler, SymfonyQueryBus $bus)
    {

        $user = $loginQueryHandler->__invoke(new LoginQuery(
                $request->request->get("username"),
                $request->request->get("password")
            )
        );

        return $this->json(
            [
                'token' => $user->token(),
                'user' => SPAUserProjector::execute($user)
            ]

        );
    }

}
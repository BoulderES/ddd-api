<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\Security\LoginQuery;
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
     * @param SymfonyQueryBus $bus
     * @return string
     */
    public function index(Request $request, SymfonyQueryBus $bus)
    {

        $user = $bus->query(new LoginQuery(
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
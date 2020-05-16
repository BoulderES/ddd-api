<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Application\Security\LoginQuery;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Crm\Infrastructure\View\SPA\UserMakeup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private ExceptionHandler $exceptionHandler;

    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

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
                'user' => UserMakeup::execute($user)
            ]

        );
    }

}
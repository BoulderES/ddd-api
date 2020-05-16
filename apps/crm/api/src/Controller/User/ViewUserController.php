<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\User;


use Cuadrik\Crm\Application\User\GetUserQuery;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\UnauthorizedException;
use Cuadrik\Crm\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Crm\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Crm\Infrastructure\View\SPA\UserMakeup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewUserController extends AbstractController implements TokenAuthenticatedController
{
    private ExceptionHandler $exceptionHandler;

    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @Route("/api/auth/view-user/{uuid}", defaults={}, name="view_user")
     * @param string $uuid
     * @param SymfonyQueryBus $bus
     * @return string
     */
    public function viewUser(string $uuid, SymfonyQueryBus $bus)
    {
        if(!$user = $bus->query(new GetUserQuery($uuid)))
            UnauthorizedException::throw('This action needs a valid token! ');

        return $this->json(
            [
                'token' => $user->token(),
                'user' => UserMakeup::execute($user)
            ]

        );
    }
}
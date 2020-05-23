<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\User;


use Cuadrik\Crm\Companies\Application\User\GetUserQuery;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Crm\Companies\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Crm\Companies\Infrastructure\Projections\SPAUserProjector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewUserController extends AbstractController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/view-user/{uuid}", defaults={}, name="view_user")
     * @param string $uuid
     * @param SymfonyQueryBus $bus
     * @return string
     */
    public function viewUser(string $uuid, SymfonyQueryBus $bus)
    {
        if(!$user = $bus->query(new GetUserQuery($uuid)))
            ExceptionManager::throw('This action needs a valid token! ');

        return $this->json(
            [
                'token' => $user->token(),
                'user' => SPAUserProjector::execute($user)
            ]

        );
    }
}